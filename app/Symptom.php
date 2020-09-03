<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    //

    public function faqsAssign () {
        return $this->hasMany('App\FaqAssign', 'assign_value', 'id')->where('type', 'symptom');
    }


    public function services()
    {
        return $this->belongsToMany('App\Service', 'symptom_service',
            'symptom_id','service_id');
    }


    public function saveSymptom($request)
    {
        if (!empty($request)) {
            $this->title =  filter_var($request->title, FILTER_SANITIZE_STRING);
            $this->slug = str_slug(filter_var($request->title, FILTER_SANITIZE_STRING));
            $this->type = filter_var($request->type, FILTER_SANITIZE_STRING);
            $this->description = $request->desc;
            $old_path = Helper::PublicPath() . '/uploads/symptoms/temp';
            $new_path = Helper::PublicPath() . '/uploads/symptoms/';
            if (!empty($request['symptom_image'])) {
                $filename = $request['symptom_image'];
                if (file_exists($old_path . '/' . $request['symptom_image'])) {
                    if (!file_exists($new_path)) {
                        File::makeDirectory($new_path, 0755, true, true);
                    }
                    $filename = time() . '-' . $request['symptom_image'];
                    if (!empty(Helper::getImageSizes('symptom'))) {
                        foreach (Helper::getImageSizes('symptom') as $key => $size) {
                            if (file_exists($old_path . '/' . $key . '-' . $request['symptom_image'])) {
                                rename($old_path . '/' . $key . '-' . $request['symptom_image'], $new_path . '/' . $key . '-' . $filename);
                            }
                        }
                        rename($old_path . '/' . $request['symptom_image'], $new_path . '/' . $filename);
                    } else {
                        rename($old_path . '/' . $request['symptom_image'], $new_path . '/' . $filename);
                    }
                }
                $this->image = $filename;
            } else {
                $this->image = null;
            }
            $this->save();
            return 'success';
        }
    }

    public function updateSymptom($request, $id)
    {
        if (!empty($id) && !empty($request)) {
            $symptom = self::find($id);
            if ($symptom->title != $request['title']) {
                $symptom->slug  =  str_slug(filter_var($request['title'], FILTER_SANITIZE_STRING));
            }
            $symptom->title = filter_var($request->title, FILTER_SANITIZE_STRING);
            $symptom->type = filter_var($request->type, FILTER_SANITIZE_STRING);
            $symptom->description = $request->desc;
            $old_path = Helper::PublicPath() . '/uploads/symptoms/temp';
            $new_path = Helper::PublicPath() . '/uploads/symptoms/';
            if (!empty($request['symptom_image'])) {
                $filename = $request['symptom_image'];
                if (file_exists($old_path . '/' . $request['symptom_image'])) {
                    if (!file_exists($new_path)) {
                        File::makeDirectory($new_path, 0755, true, true);
                    }
                    $filename = time() . '-' . $request['symptom_image'];
                    if (!empty(Helper::getImageSizes('symptom'))) {
                        foreach (Helper::getImageSizes('symptom') as $key => $size) {
                            if (file_exists($old_path . '/' . $key . '-' . $request['symptom_image'])) {
                                rename($old_path . '/' . $key . '-' . $request['symptom_image'], $new_path . '/' . $key . '-' . $filename);
                            }
                        }
                        rename($old_path . '/' . $request['symptom_image'], $new_path . '/' . $filename);
                    } else {
                        rename($old_path . '/' . $request['symptom_image'], $new_path . '/' . $filename);
                    }
                }
                $symptom->image = $filename;
            } else {
                $symptom->image = null;
            }
            $symptom->save();
        }
    }
}
