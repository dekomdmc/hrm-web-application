<?php

namespace App\Exports;

use App\Client;
use App\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Users;

class ClientExport implements WithHeadings, FromCollection
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $users = User::query()->where('type', 'client')->get(['id', 'name', 'email']);
        foreach ($users as $user) {
            $phone = Client::query()->where('user_id', $user->id)->get(['mobile']);
            unset($user->id);
            $user->phone = $phone[0]->mobile;
        }
        return $users;
    }

    public function headings(): array
    {
        return ['NAME', 'EMAIL', 'MOBILE'];
    }
}
