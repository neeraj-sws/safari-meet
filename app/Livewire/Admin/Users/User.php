<?php

namespace App\Livewire\Admin\Users;


use App\Helpers\UserHelper;
use App\Mail\DynamicMail;
use App\Models\User  as Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\{Layout, On, Validate};
use Livewire\{Component, WithPagination};
use App\Rules\ValidPhoneNumber;

#[Layout('components.layouts.admin-app')]
class User extends Component
{
    use WithPagination;

    public $itemId;
    public $name, $email, $phone_number, $search = '', $ShowRemark = false;
    public $isEditing = false, $user_id, $remark, $status;

    public $pageTitle = 'Users';
    public $model = Model::class;
    public $view = 'livewire.admin.users.user';


    public function render()
    {
        $items = $this->model::orderBy('updated_at', 'desc')->where('user_type', 0)
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->paginate(10);
        return view($this->view, compact('items'));
    }
    
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function rules()
    {
        $table = (new $this->model)->getTable();

        return [
            'email' => $this->isEditing
                ? 'required|string|max:255|email:rfc,dns|unique:' . $table . ',email,' . $this->itemId
                : 'required|string|max:255|email:rfc,dns|unique:' . $table . ',email',
            'name' => [
                'required',
                'string',
                'min:3',
                'max:50',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Name cannot have leading or trailing spaces.');
                    }
                },
            ],
            'phone_number' => ['required',  'numeric',  'digits:10', new ValidPhoneNumber(),],
        ];
    }


    public function store()
    {
        $this->validate($this->rules());
        $password = $this->generateSecurePassword();

        $user = $this->model::create([
            'name' => $this->name,
            'email' => $this->email,
            'status' => 1,
            'user_type' => 1,
            'phone_number' => $this->phone_number,
            'password' => Hash::make($password),
            // 'password' => Hash::make(123123),
        ]);



        $data = [
            'user_name' => $user->name,
            'status' => ($user->status == 1) ? 'Active' : 'In-Active',
            'remark' => $user->remark ?? 'Active',
            'year' => date('Y'),
            'username' => $user->email,
            'password' => $password,
            'login_link' => route('login')
        ];

        $parsed = UserHelper::parseTemplate('REGISTRATIONSTATUS', $data);
        Mail::to($user->email)->queue(
            new DynamicMail($parsed['subject'], $parsed['body'])
        );

        $this->resetForm();
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' Added Successfully'
        ]);
    }

    function generateSecurePassword($length = 16)
    {
        return substr(str_replace(['/', '+', '='], '', base64_encode(random_bytes($length * 2))), 0, $length);
    }


    public function edit($id)
    {
        $this->resetForm();
        $item = $this->model::findOrFail($id);

        $this->itemId = $item->id;
        $this->name = $item->name;
        $this->email = $item->email;
        $this->phone_number = $item->phone_number;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate($this->rules());

        $this->model::findOrFail($this->itemId)->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
        ]);

        $this->resetForm();
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' Updated Successfully'
        ]);
    }

    public function confirmDelete($id)
    {
        $this->itemId = $id;

        $this->dispatch('swal:confirm', [
            'title' => 'Are you sure?',
            'text' => 'This action cannot be undone.',
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'cancelButtonText' => 'Cancel',
            'action' => 'delete'
        ]);
    }

    #[On('delete')]
    public function delete()
    {
        $this->model::destroy($this->itemId);

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' deleted successfully!'
        ]);
    }

    public function resetForm()
    {
        $this->reset(['name', 'email', 'phone_number', 'itemId', 'isEditing']);
        $this->resetValidation();
    }

    public function publishedStatus($id, $status)
    {
        $user = $this->model::findOrFail($id);
        if (!empty($user)) {
            $this->status = $status;
            if ($status == 2) {
                $this->ShowRemark = true;
                $this->user_id = $user->id;
            } else {
                $password = $this->generateSecurePassword();

                $data = [
                    'user_name' => $user->name,
                    'status' => ($status == 1) ? 'Active' : 'In-Active',
                    'remark' => $user->remark ?? 'Active',
                    'year' => date('Y'),
                    'username' => $user->email,
                    'password' => $password,
                    'login_link' => route('login')
                ];

                $parsed = UserHelper::parseTemplate('REGISTRATIONSTATUS', $data);
                Mail::to($user->email)->queue(
                    new DynamicMail($parsed['subject'], $parsed['body'])
                );
                $user->status =  $this->status;
                $user->password =  Hash::make($password);
                $user->save();
                $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
            }
        }
    }

    public function submitRemark()
    {
        $this->validate([
            'remark' => 'required|string|min:3',
        ]);
        $password = $this->generateSecurePassword();
        $user = $this->model::findOrFail($this->user_id);
        $user->status =  $this->status;
        $user->remark = $this->remark;
        $user->password =  Hash::make($password);
        $user->save();
        $data = [
            'user_name' => $user->name,
            'status' => ($this->status == 1) ? 'Active' : 'In-Active',
            'remark' => $user->remark ?? 'Active',
            'year' => date('Y'),
            'username' => $user->email,
            'password' => $password,
            'login_link' => route('login')
        ];

        $parsed = UserHelper::parseTemplate('REGISTRATIONSTATUS', $data);
        Mail::to($user->email)->queue(
            new DynamicMail($parsed['subject'], $parsed['body'])
        );

        $this->reset(['ShowRemark', 'remark']);

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }
}
