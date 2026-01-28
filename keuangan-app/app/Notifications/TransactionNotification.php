<?php

namespace App\Notifications; 
// Menentukan namespace 

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
// Mengimpor trait dan class yang dibutuhkan dari Laravel

class TransactionNotification extends Notification
{
    use Queueable;
    // notifikasi muncul dan tersimpan setelah data di create

    protected $transaction;
    // menyimpan data transaksi yang akan dimasukkan di notifikasi

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
        // Constructor menerima objek transaksi dan menyimpannya dalam properti $transaction
    }

    public function via($notifiable)
    {
        return ['database'];
        // Dalam hal ini, hanya disimpan ke database 
    }

    public function toDatabase($notifiable)
    {
        // Method ini menentukan data yang akan disimpan ke tabel notifikasi di database
        return [
            'title'   => 'Transaksi Baru',
            // Judul notifikasi

            'message' => 'Rp ' . number_format($this->transaction->amount, 0, ',', '.') 
                        . ' (' . $this->transaction->category->name . ') '
                        . ' ditambahkan oleh ' . ($this->transaction->user->name ?? ' Admin '),
            // Pesan notifikasi berisi jumlah transaksi, kategori, dan nama user yang menambahkan transaksi.
            // Fungsi number_format digunakan untuk memformat angka menjadi format Rupiah
            // (??) jika user tidak ada, maka ditampilkan 'Admin'

            'url'     => url('/transactions/' . $this->transaction->id),
            // URL yang mengarah ke detail transaksi di aplikasi
        ];
    }
}
