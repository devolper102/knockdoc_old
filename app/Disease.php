<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Algolia\ScoutExtended\Facades\Algolia;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Disease extends Model
{
    //
    use Searchable;
        /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {

        return 'disease';
    }

    public function faqsAssign () {
        return $this->hasMany('App\FaqAssign', 'assign_value', 'id')->where('type', 'diseases');
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
     public function services()
    {
        return $this->belongsToMany('App\Service', 'service_disease',
           'disease_id','service_id');
    }
    
    public function treatment()
    {
        return $this->belongsToMany('App\Treatment', 'disease_treatment', 'disease_id', 'treatment_id');
    }


    public function toSearchableArray()
    {

        $array = $this->toArray();

        // Customize array...
        $array = $this->transform($array);

        return $array;
    }
    /**
     * Get the Disease associated with the User.
     *
     * @return relation
     */
    public function user_meta()
    {
        return $this->belongsToMany('App\UserMeta', 'user_disease',
            'disease_id', 'user_id');
    }


    public function storeDisease($request)
    {
        if (!empty($request)) {
            $this->title = filter_var($request['title'], FILTER_SANITIZE_STRING);
            $slug = filter_var($request['title'], FILTER_SANITIZE_STRING);
            $this->slug = str::slug($slug,'-');
            $this->description = filter_var($request['description'], FILTER_SANITIZE_STRING);
//            $this->parent = filter_var($request['parent'], FILTER_VALIDATE_INT);
            $old_path = Helper::PublicPath() . '/uploads/disease/temp';
            if (!empty($request['disease_image'])) {
                $filename = $request['disease_image'];
                if (file_exists($old_path . '/' . $request['disease_image'])) {
                    $new_path = Helper::PublicPath() . '/uploads/disease/';
                    if (!file_exists($new_path)) {
                        File::makeDirectory($new_path, 0755, true, true);
                    }
                    $filename = time() . '-' . $request['disease_image'];
                    if (!empty(Helper::getImageSizes('disease'))) {
                        foreach (Helper::getImageSizes('disease') as $key => $size) {
                            rename($old_path . '/' . $key . '-' . $request['disease_image'], $new_path . '/' . $key . '-' . $filename);
                        }
                        rename($old_path . '/' . $request['disease_image'], $new_path . '/' . $filename);
                    } else {
                        rename($old_path . '/' . $request['disease_image'], $new_path . '/' . $filename);
                    }
                }
                $this->flag = filter_var($filename, FILTER_SANITIZE_STRING);
            } else {
                $this->flag = null;
            }
            $this->save();
        }
    }

    /**
     * Update disease in database
     *
     * @param mixed   $request get req attributes
     * @param integer $id      get location ID
     *
     * @return \Illuminate\Http\Response
     */
    public function updateDisease($request, $id)
    {
//        dd($request->all());
        if (!empty($request) && !empty($id)) {
            $disease = self::find($id);
            if ($disease->title != $request['title']) {
                $slug  =  filter_var($request['title'], FILTER_SANITIZE_STRING);
                $disease->slug = Str::slug($slug,'-');
            }
            
            $parent_cat = filter_var($request['parent'], FILTER_VALIDATE_INT);
            $disease->title = filter_var($request['title'], FILTER_SANITIZE_STRING);

            $disease->description = ($request['description']);
            $disease->parent = $parent_cat;
            $old_path = Helper::PublicPath() . '/uploads/disease/temp';
            if (!empty($request['disease_image'])) {
                $filename = $request['disease_image'];
                if (file_exists($old_path . '/' . $request['disease_image'])) {
                    $new_path = Helper::PublicPath() . '/uploads/disease/';
                    if (!file_exists($new_path)) {
                        File::makeDirectory($new_path, 0755, true, true);
                    }
                    $filename = time() . '-' . $request['disease_image'];
                    if (!empty(Helper::getImageSizes('disease'))) {
                        foreach (Helper::getImageSizes('disease') as $key => $size) {
                            rename($old_path . '/' . $key . '-' . $request['disease_image'], $new_path . '/' . $key . '-' . $filename);
                        }
                        rename($old_path . '/' . $request['disease_image'], $new_path . '/' . $filename);
                    } else {
                        rename($old_path . '/' . $request['disease_image'], $new_path . '/' . $filename);
                    }
                }
                $disease->flag = filter_var($filename, FILTER_SANITIZE_STRING);
            } else {
                $disease->flag = null;
            }
            $disease->save();
        }
    }
}
