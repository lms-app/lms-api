<?php
declare(strict_types=1);

namespace Modules\User\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\ProfileRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

final class UserController extends Controller implements UserProfileInterface
{
    public function profile(ProfileRequest $profileRequest): JsonResponse
    {
        /** @var User $user */
        $user = $profileRequest->user();

        $rules = [];
        $permissions = [];

        /** @var Role $role */
        foreach ($user->roles()->get() as $role) {
            /** @var Permission $permission */
            foreach ($role->permissions()->get() as $permission) {
                list($subject, $action) = explode('.', $permission->getAttribute('name'));
                $permissions[$subject][] = $action;
            }
        }

        foreach ($permissions as $subject => $permission) {
            $rules[] = [
                'action' => $permission,
                'subject' => [$subject]
            ];
        }

        return new JsonResponse(
            [
                'data' => [
                    [
                        'id' => $user->getId(),
                        'about_me' => $user->getAboutMe(),
                        'need_change_password' => false,
                        'avatar' => null,
                        'email' => $user->getEmail(),
                        'privemobtel' => $user->getPhone(),
                        'fullname' => $user->getFullName(),
                        'confirm_tabnr' => true,
                        'rules' => $rules,
                        'jobs' => [
                            'jobid' => 1,
                            'jobname' => 'Работник Года',
                        ],
                        'objs' => [
                            'objid' => 1,
                            'jobname' => 'ИТ отдел',
                        ],
                        'orgs' => [
                            'objid' => 1,
                            'jobname' => 'ООО ИТ',
                        ],
                        'selected_tabnr' => 123456,
                        'tabnrs' => [
                            123456
                        ],
                        'tabnrs_info' => [
                            [
                                'is_active' => true,
                                'is_fired' => false,
                                'is_selected' => true,
                                'jobname' => 'Работник Года',
                                'objname' => 'ИТ отдел',
                                'orgname' => 'ООО ИТ',
                                'tabnr' => 123456,
                            ]
                        ]
                    ]
                ]
            ]
        );
    }
}
