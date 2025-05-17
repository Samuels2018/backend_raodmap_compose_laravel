<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;
use Illuminate\Support\Str;
use App\Models\Image;

class ImageController extends Controller {

  private function validateImage ($data) {
    return validator($data, [
      'transformations' => 'required|array',
      'transformations.resize' => 'sometimes|array',
      'transformations.resize.width' => 'sometimes|integer|min:1',
      'transformations.resize.height' => 'sometimes|integer|min:1',
      'transformations.crop' => 'sometimes|array',
      'transformations.crop.width' => 'sometimes|integer|min:1',
      'transformations.crop.height' => 'sometimes|integer|min:1',
      'transformations.crop.x' => 'sometimes|integer|min:0',
      'transformations.crop.y' => 'sometimes|integer|min:0',
      'transformations.rotate' => 'sometimes|numeric',
      'transformations.format' => 'sometimes|in:jpeg,png,gif,webp',
      'transformations.filters' => 'sometimes|array',
      'transformations.filters.grayscale' => 'sometimes|boolean',
      'transformations.filters.sepia' => 'sometimes|boolean',
      'transformations.watermark' => 'sometimes|array',
      'transformations.watermark.path' => 'sometimes|string',
      'transformations.watermark.position' => 'sometimes|string',
      'transformations.watermark.x' => 'sometimes|integer',
      'transformations.watermark.y' => 'sometimes|integer',
      'transformations.flip' => 'sometimes|in:horizontal,vertical',
      'transformations.mirror' => 'sometimes|boolean',
      'transformations.compress' => 'sometimes|integer|min:0|max:100',
    ]);
  }


  public function index(Request $request) {
    $perPage = $request->input('limit', 10);
    $images = $request->user()->images()->paginate($perPage);

    return response()->json($images);
  }

  public function store(Request $request) {
    $request->validate([
      'image' => 'required|image|max:10240' // 10MB max
    ]);

    $user = $request->user();
    $file = $request->file('image');
    $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
    $path = 'users/' . $user->id . '/' . $filename;

    // Store original image
    $image = InterventionImage::make($file);
    Storage::disk('s3')->put($path, (string) $image->encode());

    // Create image record
    $imageModel = $user->images()->create([
      'original_path' => $path,
      'filename' => $filename,
      'mime_type' => $file->getMimeType(),
      'size' => $file->getSize(),
    ]);

    return response()->json([
      'message' => 'Image uploaded successfully',
      'image' => $imageModel,
      'url' => $imageModel->url
    ], 201);
  }

  public function show(Image $image) {
    $this->authorize('view', $image);

    $imageContent = Storage::disk('s3')->get($image->original_path);

    return response($imageContent)
      ->header('Content-Type', $image->mime_type);
  }

  public function transform(Request $request, Image $image) {
    $this->authorize('update', $image);

    $validator = $this->validateImage($request->all());

    if ($validator->fails()) {
      return response()->json([
        'errors' => $validator->errors()
      ], 422);
    }

    $transformations = $request->transformations;
    $originalImage = Storage::disk('s3')->get($image->original_path);
    $processedImage = InterventionImage::make($originalImage);

    // Apply transformations
    if (isset($transformations['resize'])) {
      $width = $transformations['resize']['width'] ?? null;
      $height = $transformations['resize']['height'] ?? null;
      $processedImage->resize($width, $height, function ($constraint) {
          $constraint->aspectRatio();
      });
    }

    if (isset($transformations['crop'])) {
      $width = $transformations['crop']['width'];
      $height = $transformations['crop']['height'];
      $x = $transformations['crop']['x'] ?? 0;
      $y = $transformations['crop']['y'] ?? 0;
      $processedImage->crop($width, $height, $x, $y);
    }

    if (isset($transformations['rotate'])) {
      $processedImage->rotate($transformations['rotate']);
    }

    if (isset($transformations['format'])) {
      $format = $transformations['format'];
      $mimeType = 'image/' . $format;
    } else {
      $mimeType = $image->mime_type;
    }

    if (isset($transformations['filters'])) {
      if ($transformations['filters']['grayscale'] ?? false) {
        $processedImage->greyscale();
      }
      if ($transformations['filters']['sepia'] ?? false) {
        $processedImage->sepia();
      }
    }

    if (isset($transformations['watermark'])) {
      $watermark = InterventionImage::make(Storage::disk('s3')->get($transformations['watermark']['path']));
      $position = $transformations['watermark']['position'] ?? 'bottom-right';
      $x = $transformations['watermark']['x'] ?? 10;
      $y = $transformations['watermark']['y'] ?? 10;
      $processedImage->insert($watermark, $position, $x, $y);
    }

    if (isset($transformations['flip'])) {
      $processedImage->flip($transformations['flip']);
    }

    if (isset($transformations['mirror']) && $transformations['mirror']) {
      $processedImage->flip('horizontal');
    }

    if (isset($transformations['compress'])) {
      $quality = $transformations['compress'];
    } else {
      $quality = 90;
    }

    // Generate new filename for transformed image
    $transformedFilename = 'transformed_' . $image->filename;
    $transformedPath = 'users/' . $request->user()->id . '/' . $transformedFilename;

    // Store transformed image
    Storage::disk('s3')->put(
      $transformedPath,
      (string) $processedImage->encode($mimeType, $quality)
    );

    // Update image record with transformations
    $image->update([
      'transformations' => $transformations
    ]);

    return response()->json([
      'message' => 'Image transformed successfully',
      'url' => Storage::disk('s3')->url($transformedPath)
    ]);
  }

  public function destroy(Image $image) {
    $this->authorize('delete', $image);

    Storage::disk('s3')->delete($image->original_path);
    $image->delete();

    return response()->json(['message' => 'Image deleted successfully']);
  }
}
