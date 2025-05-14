<?php

namespace App\Repositories;

use App\Models\MenuCategory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\Traits\HandlesMediaUploads;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\MenuCategoryRepositoryInterface;

class MenuCategoryRepository implements MenuCategoryRepositoryInterface
{
    use HandlesMediaUploads;
    public function all(): Collection
    {
        return MenuCategory::get();
    }
    public function find(int $id): ?object
    {
        return MenuCategory::find($id);
    }
    public function create(array $data): object
    {
        return DB::transaction(function () use ($data) {
            $category = MenuCategory::create($data);
            if (isset($data['images']) && is_array($data['images'])) {
                $this->handleMediaUpload($category, $data['images'], 'category_images');
            }
            return $category;
        });
    }
    public function update(int $id, array $data): bool
    {
        return DB::transaction(function () use ($data, $id) {
            $category = MenuCategory::find($id);
            if (isset($data['images']) || isset($data['old_images'])) {
                $existingMedia = $category->getMedia('category_images');
                $oldImageFileNames = array_map(function ($url) {
                    return basename($url);
                }, $data['old_images'] ?? []);
                $mediaToDelete = $existingMedia->filter(function ($media) use ($oldImageFileNames) {
                    return !in_array($media->file_name, $oldImageFileNames);
                });
                foreach ($mediaToDelete as $media) {
                    $media->delete();
                }
                if (isset($data['images'])) {
                    foreach ($data['images'] as $file) {
                        if ($file instanceof UploadedFile && $file->isValid()) {
                            $category->addMedia($file)->toMediaCollection('category_images');
                        }
                    }
                }
            }
            return $category ? $category->update($data) : false;
        });
    }
    public function delete(int $id): bool
    {
        $category = MenuCategory::find($id);
        return $category ? $category->delete() : false;
    }
}
