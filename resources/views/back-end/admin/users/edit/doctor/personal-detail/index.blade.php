 {!! Form::open(['url' => '', 'class' =>'dc-formtheme', 'id' =>'edit-user-details', '@submit.prevent'=>'updateUserProfile("'.$id.'", "'.trans("lang.update_role_war").'", "'.trans("lang.update_role_note").'")'])!!}
	@include('back-end.admin.users.edit.detail')
    @include('back-end.admin.users.edit.doctor.personal-detail.fees-range')
    @include('back-end.admin.users.edit.doctor.personal-detail.percentage')
    @include('back-end.doctors.profile-settings.personal-detail.diseases')
    @include('back-end.admin.users.edit.doctor.personal-detail.actions')
    @include('back-end.admin.users.edit.doctor.personal-detail.leave')
    @include('back-end.admin.users.edit.doctor.personal-detail.media')
    @include('back-end.admin.users.edit.doctor.personal-detail.location')
    @include('back-end.admin.users.edit.doctor.personal-detail.membership')
    
                            <input type="hidden" name="role" value="<?php echo $user_role; ?>">	
                            <div class="dc-experienceaccordion">
                                <div class="dc-updatall la-updateall-holder">
                                    {!! Form::submit(trans('lang.btn_save'), ['class' => 'dc-btn']) !!}
                                </div>
                            </div>
                        {!! Form::close(); !!}