<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
   public $table = 'procedures';
     protected $fillable = [
'name','fee','color','image'];
 public function saveProcedure($request)
    {
        
         $this ->name = $request->name;
        $this ->fee = $request->fee;
        $this ->color = $request->color;
            $old_path = Helper::PublicPath() . '/uploads/procedure/temp';
            $new_path = Helper::PublicPath() . '/uploads/procedure/';
            if (!empty($request['procedure_image'])) {
                $filename = $request['procedure_image'];
                if (file_exists($old_path . '/' . $request['procedure_image'])) {
                    if (!file_exists($new_path)) {
                        File::makeDirectory($new_path, 0755, true, true);
                    }
                    $filename = time() . '-' . $request['procedure_image'];
                    if (!empty(Helper::getImageSizes('symptom'))) {
                        foreach (Helper::getImageSizes('symptom') as $key => $size) {
                            if (file_exists($old_path . '/' . $key . '-' . $request['procedure_image'])) {
                                rename($old_path . '/' . $key . '-' . $request['procedure_image'], $new_path . '/' . $key . '-' . $filename);
                            }
                        }
                        rename($old_path . '/' . $request['procedure_image'], $new_path . '/' . $filename);
                    } else {
                        rename($old_path . '/' . $request['procedure_image'], $new_path . '/' . $filename);
                    }
                }
                $this->image = $filename;
            } else {
                $this->image = null;
            }
        $this ->save();
            return 'success';
    }
        public function users()
    {
        return $this->belongsToMany('App\User', 'user_procedure', 'prodedure_id', 'user_id');
    }

        public function updateProcedure($request, $procedure)
    {
      if (!empty($procedure) && !empty($request)) {
      	
       $procedure = self::find($procedure);
       $procedure->name  = $request->get('name');
        $procedure->fee  = $request->get('fee');
        $procedure->color  = $request->get('color');
          $old_path = Helper::PublicPath() . '/uploads/procedure/temp';
          $new_path = Helper::PublicPath() . '/uploads/procedure/';
            if (!empty($request['procedure_image'])) {
                $filename = $request['procedure_image'];
                if (file_exists($old_path . '/' . $request['procedure_image'])) {
                    if (!file_exists($new_path)) {
                        File::makeDirectory($new_path, 0755, true, true);
                    }
                    $filename = time() . '-' . $request['procedure_image'];
                    if (!empty(Helper::getImageSizes('procedure'))) {
                        foreach (Helper::getImageSizes('procedure') as $key => $size) {
                            if (file_exists($old_path . '/' . $key . '-' . $request['procedure_image'])) {
                                rename($old_path . '/' . $key . '-' . $request['procedure_image'], $new_path . '/' . $key . '-' . $filename);
                            }
                        }
                        rename($old_path . '/' . $request['procedure_image'], $new_path . '/' . $filename);
                    } else {
                        rename($old_path . '/' . $request['procedure_image'], $new_path . '/' . $filename);
                    }
                }
                $procedure->image = $filename;
            } else {
                $procedure->image = null;
            }
        $procedure ->save();
         return 'success';

        
    }
}
}
