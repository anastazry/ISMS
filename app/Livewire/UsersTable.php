<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\TableComponent;

class UsersTable extends TableComponent
{
    // Define the model for the table
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSlot('users-table-slot'); // Set the slot name here
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")->sortable(),
            Column::make("Name", "name")->sortable()->searchable(),
            Column::make("Email", "email")->sortable()->searchable(),
            Column::make("Phone no", "phone_no")->sortable()->searchable(),
            Column::make("Worker id", "worker_id")->sortable()->searchable(),
            Column::make("Role", "role")->sortable(),
            Column::make("First time status", "first_time_status")->sortable(),
            Column::make("AccessToken", "accessToken")->sortable(),
            Column::make("Username", "username")->sortable()->searchable(),
            Column::make("Created at", "created_at")->sortable(),
            Column::make("Updated at", "updated_at")->sortable(),
        ];
    }

    // This method handles the query automatically
    public function query()
    {
        return User::query();
    }

    public function render()
    {
        return view('livewire.users-table');
    }
}
