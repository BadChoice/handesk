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
    |
    */

    'accepted'        => 'O campo :attribute deve ser aceito.',
    'active_url'      => 'O campo :attribute não é uma URL válido.',
    'after'           => 'O campo :attribute deve ser uma data maior que :date.',
    'after_or_equal'  => 'O campo :attribute deve ser uma data maior ou igual à :date.',
    'alpha'           => 'O campo :attribute deve conter somente letras.',
    'alpha_dash'      => 'O campo :attribute deve conter somente letras, números, and traços.',
    'alpha_num'       => 'O campo :attribute deve conter somente letras e números.',
    'array'           => 'O campo :attribute deve ser um array.',
    'before'          => 'O campo :attribute deve ser uma data menor que :date.',
    'before_or_equal' => 'O campo :attribute deve ser uma data menor ou igual à :date.',
    'between'         => [
        'numeric' => 'O campo :attribute deve estar entre :min e :max.',
        'file'    => 'O campo :attribute deve estar entre :min e :max kilobytes.',
        'string'  => 'O campo :attribute deve estar entre :min e :max caracteres.',
        'array'   => 'O campo :attribute deve ter entre :min e :max itens.',
    ],
    'boolean'        => 'O campo :attribute deve ser verdadeiro ou falso.',
    'confirmed'      => 'O campo de confirmação :attribute não coincide.',
    'date'           => 'O campo :attribute não é uma data válida.',
    'date_format'    => 'O campo :attribute não corresponde ao formato :format.',
    'different'      => 'O campo :attribute e :other são diferentes.',
    'digits'         => 'O campo :attribute deve ter :digits digitos.',
    'digits_between' => 'O campo :attribute deve ter entre :min e :max digitos.',
    'dimensions'     => 'O campo :attribute tem dimensões de imagem inválidas.',
    'distinct'       => 'O campo :attribute tem o valor duplicado.',
    'email'          => 'O campo :attribute deve ser um e-mail válido.',
    'exists'         => 'O campo :attribute selecionado é inválido.',
    'file'           => 'O campo :attribute deve ser um arquivo.',
    'filled'         => 'O campo :attribute deve ter um valor.',
    'image'          => 'O campo :attribute deve ser uma imagem.',
    'in'             => 'O campo :attribute selecionado é inválido.',
    'in_array'       => 'O campo :attribute não existe em :other.',
    'integer'        => 'O campo :attribute deve ser um inteiro.',
    'ip'             => 'O campo :attribute deve ser um endereço de IP válido.',
    'ipv4'           => 'O campo :attribute deve ser um endereço de IPv4 válido.',
    'ipv6'           => 'O campo :attribute deve ser um endereço IPv6 válido.',
    'json'           => 'O campo :attribute deve ser um JSON válido.',
    'max'            => [
        'numeric' => 'O campo :attribute não deve ser maior que :max.',
        'file'    => 'O campo :attribute não deve ser maior que :max kilobytes.',
        'string'  => 'O campo :attribute não deve ser maior que :max caracteres.',
        'array'   => 'O campo :attribute não deve ter mais que :max itens.',
    ],
    'mimes'     => 'O campo :attribute deve ser um arquivo do tipo: :values.',
    'mimetypes' => 'O campo :attribute deve ser um arquivo do tipo: :values.',
    'min'       => [
        'numeric' => 'O campo :attribute deve ser menor que :min.',
        'file'    => 'O campo :attribute deve ser menor que :min kilobytes.',
        'string'  => 'O campo :attribute deve ser menor que :min caracteres.',
        'array'   => 'O campo :attribute deve ter no mínimo :min itens.',
    ],
    'not_in'               => 'O campo :attribute selecionado é inválido.',
    'numeric'              => 'O campo :attribute deve ser um número.',
    'present'              => 'O campo :attribute deve estar presente.',
    'regex'                => 'O formato do campo :attribute é inválido.',
    'required'             => 'O campo :attribute é obrigatório.',
    'required_if'          => 'O campo :attribute é obrigatório quando :other é :value.',
    'required_unless'      => 'O campo :attribute é obrigatório a menos que :other esteja em :values.',
    'required_with'        => 'O campo :attribute é obrigatório quando :values está presente.',
    'required_with_all'    => 'O campo :attribute é obrigatório quando :values está presente.',
    'required_without'     => 'O campo :attribute é obrigatório quando :values não está presente.',
    'required_without_all' => 'O campo :attribute é obrigatório quando nenhum dos :values estão presentes.',
    'same'                 => 'O campo :attribute e :other deve ser iguais.',
    'size'                 => [
        'numeric' => 'O campo :attribute deve ter :size.',
        'file'    => 'O campo :attribute deve ter :size kilobytes.',
        'string'  => 'O campo :attribute deve ter :size caracteres.',
        'array'   => 'O campo :attribute deve conter :size itens.',
    ],
    'string'   => 'O campo :attribute deve ser uma string.',
    'timezone' => 'O campo :attribute deve ser um fuso horário válido.',
    'unique'   => 'O campo :attribute já foi tirado.',
    'uploaded' => 'O campo :attribute falhou ao carregar.',
    'url'      => 'O fomato do campo :attribute é inválido.',

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
        'name'                  => 'nome',
        'username'              => 'usuário',
        'email'                 => 'email',
        'first_name'            => 'nome',
        'last_name'             => 'sobrenome',
        'password'              => 'senha',
        'password_confirmation' => 'confirmação de senha',
        'city'                  => 'cidade',
        'country'               => 'país',
        'address'               => 'endereço',
        'phone'                 => 'telefone',
        'mobile'                => 'celular',
        'age'                   => 'idade',
        'sex'                   => 'sexo',
        'gender'                => 'gênero',
        'year'                  => 'ano',
        'month'                 => 'mês',
        'day'                   => 'dia',
        'hour'                  => 'hora',
        'minute'                => 'minuto',
        'second'                => 'segundo',
        'title'                 => 'título',
        'content'               => 'conteúdo',
        'body'                  => 'corpo',
        'description'           => 'descrição',
        'excerpt'               => 'extrato',
        'date'                  => 'data',
        'time'                  => 'hora',
        'subject'               => 'assunto',
        'message'               => 'mensagem',
    ],
];
