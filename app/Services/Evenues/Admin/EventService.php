<?php
declare(strict_types=1);

namespace App\Services\Evenues\Admin;

use App\Http\Requests\Admin\Event\UpdateRequest;
use App\Http\Requests\Admin\Event\CreateRequest;
use App\Models\Evenues\Event;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use RuntimeException;
use Exception;
use DateTime;

class EventService
{
    public function createEvent(CreateRequest $request): void
    {
        $data = $request->validated();

        try {
            // Date stored in database as 'YYYY-mm-dd HH:mm:ss' and here its convert just 'YYYY-mm-dd' ti the full format
            $data['event_date'] = DateTime::createFromFormat('Y-m-d', $data['event_date'])->format('Y-m-d H:i:s');

            if ($request->hasFile('poster')) {
                $file = $request->file('poster');

                // Get temporary path
                $tempPath = $file->getRealPath();

                $image = Image::read($tempPath);

                // Crop image to the 800x800 pixels from the center
                $image->cover(800, 800, 'center');

                // Generate unique filename
                $fileName = $file->hashName();

                $filePath = 'public/images/' . $fileName;

                $data['poster'] = str_replace('public/', '', $filePath);;

            } else {
                throw new RuntimeException('Cannot find attached image file');
            }
            Event::firstOrCreate($data);

            if (!Storage::disk('public')->exists($data['poster'])) {
                Storage::put($filePath, (string)$image->encode());
            }
        } catch (Exception $err) {
            throw new RuntimeException($err->getMessage());
        }
    }

    public function updateEvent(UpdateRequest $request, Event $event): void
    {
        $data = $request->validated();
        $imageChanged = false;
        $image = null;
        $filePath = '';

        try {

            $oldDate = explode(' ', $event->event_date)[0];
            $data['event_date'] = DateTime::createFromFormat('Y-m-d', $data['event_date'])->format('Y-m-d H:i:s');

            if ($request->hasFile('poster')) {
                $file = $request->file('poster');

                // Get temporary path
                $tempPath = $file->getRealPath();

                $image = Image::read($tempPath);

                $image->resize(800, 800);

                // Generate unique filename
                $fileName = $file->hashName();

                $filePath = 'public/images/' . $fileName;

                // Here 'public/' was removed from path because in database it stored like this 'images/filename.jpg'
                $data['poster'] = str_replace('public/', '', $filePath);

                $imageChanged = true;
            }

            $event->update($data);

            $event->refresh();

            if ($imageChanged && !Storage::disk('public')->exists($event->poster)) {
                Storage::put($filePath, (string)$image->encode());
            }

            // Update weather data if the new data was provided by user
            if ($oldDate !== explode(' ', $data['event_date'])[0]) {
                $redis = Cache::store('redis')->getRedis();

                $redis->hdel($data['event_date'], $event->id);
            }
        } catch (Exception $err) {
            throw new RuntimeException($err->getMessage());
        }
    }
}
