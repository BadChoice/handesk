<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
        attribute
    |
    */

    'accepted'             => ':attribute harus diterima.',
    'active_url'           => 'The :attribute bukan URL yang valid.',
    'after'                => 'The :attribute harus berupa tanggal setelah :date.',
    'after_or_equal'       => 'The :attribute harus tanggal setelah atau sama dengan :date.',
    'alpha'                => 'The :attribute hanya boleh berisi huruf.',
    'alpha_dash'           => 'The :attribute hanya boleh berisi huruf, angka, dan tanda hubung.',
    'alpha_num'            => 'The :attribute hanya boleh berisi huruf dan angka.',
    'array'                => 'The :attribute harus berupa array.',
    'before'               => 'The :attribute harus tanggal sebelum :date.',
    'before_or_equal'      => 'The :attribute harus tanggal sebelum atau sama dengan :date.',

    'between'         => [
        'numeric' => ':attribute harus antara :min dan :max.',
        'file'    => ':attribute harus antara :min dan :max kilobyte.',
        'string'  => ':attribute harus antara :min dan :max karakter.',
        'array'   => ':attribute harus memiliki antara :min dan :max item.',
    ],
    'boolean'        => 'Bidang :attribute harus benar atau salah.',
    'confirmed'      => 'Konfirmasi :attribute tidak cocok.',
    'date'           => ':attribute bukan tanggal yang valid.',
    'date_format'    => ':attribute tidak cocok dengan format :format.',
    'different'      => ':attribute dan :other harus berbeda.',
    'digits'         => ':attribute harus :digit digit.',
    'digits_between' => ':attribute harus antara :min dan :max digit.',
    'dimensions'     => ':attribute memiliki dimensi gambar yang tidak valid.',
    'distinct'       => 'Bidang :attribute memiliki nilai duplikat.',
    'email'          => ':attribute harus berupa alamat email yang valid.',
    'exists'         => ':attribute yang dipilih tidak valid.',
    'file'           => ':attribute harus berupa file.',
    'filled'         => 'Bidang :attribute harus memiliki nilai.',
    'image'          => ':attribute harus berupa gambar.',
    'in'             => ':attribute yang dipilih tidak valid.',
    'in_array'       => 'Bidang :attribute tidak ada di :other.',
    'integer'        => ':attribute harus berupa bilangan bulat.',
    'ip'             => ':attribute harus berupa alamat IP yang valid.',
    'ipv4'           => ':attribute harus berupa alamat IPv4 yang valid.',
    'ipv6'           => ':attribute harus berupa alamat IPv6 yang valid.',
    'json'           => ':attribute harus berupa string JSON yang valid.',
    'max'            => [
        'numeric' => ':attribute tidak boleh lebih besar dari :max.',
        'file'    => ':attribute tidak boleh lebih besar dari :max kilobyte.',
        'string'  => ':attribute tidak boleh lebih besar dari :max karakter.',
        'array'   => ':attribute tidak boleh memiliki lebih dari :max item.',
    ],
    'mimes'     => ':attribute harus berupa file dengan tipe: :values.',
    'mimetypes' => ':attribute harus berupa file dengan tipe: :values.',
    'min'       => [
        'numeric' => ':attribute harus minimal :min.',
        'file'    => ':attribute harus minimal :min kilobyte.',
        'string'  => ':attribute harus minimal :min karakter.',
        'array'   => ':attribute harus memiliki setidaknya :min item.',
    ],
    'not_in'               => ':attribute yang dipilih tidak valid.',
    'numeric'              => ':attribute harus berupa angka.',
    'present'              => 'Bidang :attribute harus ada.',
    'regex'                => 'Format :attribute tidak valid.',
    'required'             => 'Bidang :attribute wajib diisi.',
    'required_if'          => 'Bidang :attribute diperlukan ketika :other adalah :value.',
    'required_unless'      => 'Bidang :attribute wajib diisi kecuali :other ada di :values.',
    'required_with'        => 'Bidang :attribute diperlukan bila :nilai ada.',
    'required_with_all'    => 'Bidang :attribute diperlukan bila :nilai ada.',
    'required_without'     => 'Bidang :attribute diperlukan bila :nilai tidak ada.',
    'required_without_all' => 'Bidang :attribute diperlukan bila tidak ada :nilai yang ada.',
    'same'                 => ':attribute dan :other harus cocok.',
    'size'                 => [
        'numeric' => ':attribute harus :size.',
        'file'    => ':attribute harus :size kilobytes.',
        'string'  => ':attribute harus berupa :size karakter.',
        'array'   => ':attribute harus berisi :size item.',
    ],
    'string'   => ':attribute harus berupa string.',
    'timezone' => ':attribute harus berupa zona yang valid.',
    'unique'   => ':attribute sudah diambil.',
    'uploaded' => ':attribute gagal diunggah.',
    'url'      => 'Format :attribute tidak valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name'                  => 'nama',
        'username'              => 'nama belakang',
        'email'                 => 'surel',
        'first_name'            => 'nama depan',
        'last_name'             => 'nama keluarga',
        'password'              => 'kata sandi',
        'password_confirmation' => 'konfirmasi kata kunci',
        'city'                  => 'kota',
        'country'               => 'negara',
        'address'               => 'alamat',
        'phone'                 => 'telepon',
        'mobile'                => 'seluler',
        'age'                   => 'usia',
        'sex'                   => 'seks',
        'gender'                => 'jenis kelamin',
        'year'                  => 'tahun',
        'month'                 => 'bulan',
        'day'                   => 'hari',
        'hour'                  => 'jam',
        'minute'                => 'menit',
        'second'                => 'kedua',
        'title'                 => 'judul',
        'content'               => 'isi',
        'body'                  => 'tubuh',
        'description'           => 'keterangan',
        'excerpt'               => 'kutipan',
        'date'                  => 'tanggal',
        'time'                  => 'waktu',
        'subject'               => 'subjek',
        'message'               => 'pesan',
    ],
    'emptyBodyComment'          => 'Tidak dapat membuat komentar dengan isi kosong.',
    'commentCreated'            => 'Komentar dibuat.',
    'ticketCommentInjection'    => 'Kesalahan mengirimkan komentar. Itu tidak dikirim ke tiket yang benar.',
    'solvedTicket'              => 'Resolusi tiket.',
];
