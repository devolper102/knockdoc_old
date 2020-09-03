<?php

/**
 * Class Speciality.
 *
 * @category Doctry
 *
 * @package Doctry
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @link    http://www.amentotech.com
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use File;

use Laravel\Scout\Searchable;
use Algolia\ScoutExtended\Facades\Algolia;
use Illuminate\Support\Str;

/**
 * Class Speciality
 *
 */
class Speciality extends Model
{

    public function faqsAssign () {
        return $this->hasMany('App\FaqAssign', 'assign_value', 'id')->with('faqs')->where('type', 'speciality');
    }


    /**
     * Get the services associated with the speciality.
     *
     * @return relation
     */
    public function services()
    {
        return $this->hasMany('App\Service');
    }

    /**
     * Get the services & disease associated with the speciality.
     *
     * @return relation
     */

    public function services_symptom()
    {
        return $this->hasMany('App\Service')->with('symptom');
    }

    public function services_diseases()
    {
        return $this->hasMany('App\Service')->with('diseases');
    }

    /**
     * Get the services associated with the speciality.
     *
     * @return relation
     */
    public function user()
    {
        return $this->belongsToMany('App\User', 'user_speciality',
            'speciality_id', 'user_id')->with('roles');
    }

    /**
     * Get the speciality associated with the locations.
     *
     * @return relation
     */
    public function locations()
    {
        return $this->belongsToMany('App\Location', 'location_speciality',
            'speciality_id', 'location_id');
    }

    /**
     * Fillables for the database
     *
     * @access protected
     *
     * @var array $fillable
     */
    protected $fillable = array('title', 'slug','user_type', 'body');

    /**
     * Set slug attribute
     *
     * @param int $value page ID
     *
     * @return array
     */
    public function setSlugAttribute($value)
    {
        $temp = Str::slug($value, '-');
        if (!Speciality::all()->where('slug', $temp)->isEmpty()) {
            $i = 1;
            $new_slug = $temp . '-' . $i;
            while (!Speciality::all()->where('slug', $new_slug)->isEmpty()) {
                $i++;
                $new_slug = $temp . '-' . $i;
            }
            $temp = $new_slug;
        }
        $this->attributes['slug'] = $temp;
    }

    /**
     * Get Parent Pages
     *
     * @param mixed $request $req->attribute
     *
     * @return array
     */
    public function saveSpeciality($request)
    {

        if (!empty($request)) {
            $this->title =  filter_var($request->title, FILTER_SANITIZE_STRING);
            $this->user_type = filter_var($request->user_type, FILTER_SANITIZE_STRING);
            $this->slug = filter_var($request->title, FILTER_SANITIZE_STRING);
            $this->type = filter_var($request->type, FILTER_SANITIZE_STRING);

            $this->description = $request->desc;
            $old_path = Helper::PublicPath() . '/uploads/specialities/temp';
            $new_path = Helper::PublicPath() . '/uploads/specialities/';
            if (!empty($request['speciality_image'])) {
                $filename = $request['speciality_image'];
                if (file_exists($old_path . '/' . $request['speciality_image'])) {
                    if (!file_exists($new_path)) {
                        File::makeDirectory($new_path, 0755, true, true);
                    }
                    $filename = time() . '-' . $request['speciality_image'];
                    if (!empty(Helper::getImageSizes('speciality'))) {
                        foreach (Helper::getImageSizes('speciality') as $key => $size) {
                            if (file_exists($old_path . '/' . $key . '-' . $request['speciality_image'])) {
                                rename($old_path . '/' . $key . '-' . $request['speciality_image'], $new_path . '/' . $key . '-' . $filename);
                            }
                        }
                        rename($old_path . '/' . $request['speciality_image'], $new_path . '/' . $filename);
                    } else {
                        rename($old_path . '/' . $request['speciality_image'], $new_path . '/' . $filename);
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

    /**
     * Update speciality
     *
     * @param mixed $request $req->attribute
     * @param int   $id      id
     *
     * @return array
     */
    public function updateSpeciality($request, $id)
    {
        if (!empty($id) && !empty($request)) {
            $speciality = self::find($id);
            if ($speciality->title != $request['title']) {
                $speciality->slug  =  filter_var($request['title'], FILTER_SANITIZE_STRING);
            }
            $speciality->title = filter_var($request->title, FILTER_SANITIZE_STRING);
            $speciality->user_type = filter_var($request->user_type, FILTER_SANITIZE_STRING);
            $speciality->type = filter_var($request->type, FILTER_SANITIZE_STRING);
            $speciality->description = $request->desc;
            $old_path = Helper::PublicPath() . '/uploads/specialities/temp';
            $new_path = Helper::PublicPath() . '/uploads/specialities/';
            if (!empty($request['speciality_image'])) {
                $filename = $request['speciality_image'];
                if (file_exists($old_path . '/' . $request['speciality_image'])) {
                    if (!file_exists($new_path)) {
                        File::makeDirectory($new_path, 0755, true, true);
                    }
                    $filename = time() . '-' . $request['speciality_image'];
                    if (!empty(Helper::getImageSizes('speciality'))) {
                        foreach (Helper::getImageSizes('speciality') as $key => $size) {
                            if (file_exists($old_path . '/' . $key . '-' . $request['speciality_image'])) {
                                rename($old_path . '/' . $key . '-' . $request['speciality_image'], $new_path . '/' . $key . '-' . $filename);
                            }
                        }
                        rename($old_path . '/' . $request['speciality_image'], $new_path . '/' . $filename);
                    } else {
                        rename($old_path . '/' . $request['speciality_image'], $new_path . '/' . $filename);
                    }
                }
                $speciality->image = $filename;
            } else {
                $speciality->image = null;
            }
            $speciality->save();
        }
    }

    /**
     * For updating skills
     *
     * @param int $user_id get user ID
     *
     * @return \Illuminate\Http\Response
     */
    public static function getDoctorSpeciality($user_id)
    {
        if (!empty($user_id)) {
            return DB::table('skill_user')->select('skill_id')
                ->where('user_id', $user_id)
                ->get()->pluck('skill_id')->toArray();
        } else {
            return '';
        }
    }
}
