<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | following language lines contain default error messages used by
    | validator class. Some of these rules have multiple versions such
    | as size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'        => '必须统一字段：:attribute',
    'active_url'      => ':attribute 不是一个合法的网址',
    'after'           => ':attribute 必须是 :date之后的一个日期',
    'after_or_equal'  => ':attribute :date或之后的一个日期',
    'alpha'           => ':attribute 只能包含字符',
    'alpha_dash'      => ':attribute 只能包含字符、数字和「-」',
    'alpha_num'       => ':attribute 只能包含字符和数字',
    'array'           => ':attribute 必须是数组',
    'before'          => ':attribute 必须是 :date之前的一个日期',
    'before_or_equal' => ':attribute 必须是 :date或之前的一个人气',
    'between'         => [
        'numeric' => ':attribute 必须是:min和:max之间',
        'file'    => ':attribute 必须是:min和:maxkb之间',
        'string'  => ':attribute 必须是:min和:max字符之间',
        'array'   => ':attribute 必须是:min和:max个',
    ],
    'boolean'        => ':attribute必须是布尔值',
    'confirmed'      => ':attribute确认失败',
    'date'           => ':attribute不是一个合法的日期',
    'date_format'    => ':attribute不符合格式：:format',
    'different'      => ':attribute和:other必须不一样',
    'digits'         => ':attribute必须:digits位数',
    'digits_between' => ':attribute必须是:min和:max位数之间',
    'dimensions'     => ':attribute图片像素有误',
    'distinct'       => ':attribute值有重复',
    'email'          => ':attribute不合法的邮件地址',
    'exists'         => '选择的:attribute有误',
    'file'           => ':attribute必须是文件',
    'filled'         => '必须提供:attribute',
    'image'          => ':attribute必须是图片',
    'in'             => '选择的:attribute有误',
    'in_array'       => ':other中不存在:attribute ',
    'integer'        => ':attribute必须是整数',
    'ip'             => ':attribute必须是合法的IP地址',
    'ipv4'           => ':attribute必须是合法的IPV4地址',
    'ipv6'           => '::attribute必须是合法的IPV6地址',
    'json'           => ':attribute必须是合法的json格式',
    'max'            => [
        'numeric' => ':attribute 不能大于 :max',
        'file'    => ':attribute 不能大于 :max kb',
        'string'  => ':attribute 不能大于 than :max 字符',
        'array'   => ':attribute 不能多于 :max 个条目',
    ],
    'mimes'     => ':attribute 的类型必须是 :values',
    'mimetypes' => ':attribute 文件类型必须是： :values',
    'min'       => [
        'numeric' => ':attribute不能小于 :min',
        'file'    => ':attribute不能小于 :min kilobytes',
        'string'  => ':attribute不能小于:min characters',
        'array'   => ':attribute 中不能少于:min 个条目',
    ],
    'not_in'               => '选择的 :attribute 无效',
    'numeric'              => ':attribute 必须是数字',
    'present'              => ' 必须提供 :attribute',
    'regex'                => ':attribute 格式有误',
    'required'             => ':attribute 是必填项',
    'required_if'          => ':other等于:value时， 必须提供:attribute',
    'required_unless'      => ' :other不在:values时，必须提供 :attribute',
    'required_with'        => '包含:values时， 必须要提供:attribute',
    'required_with_all'    => '包含:values时， 必须要提供:attribute',
    'required_without'     => ':values没有时， 必须要提供:attribute',
    'required_without_all' => ':values没有时， 必须要提供:attribute',
    'same'                 => ':attribute 和 :other 必须一致',
    'size'                 => [
        'numeric' => ':attribute 必须等于 :size',
        'file'    => ':attribute 必须等于 :size kb',
        'string'  => ':attribute 必须等于 :size 字符',
        'array'   => ':attribute 必须包含 :size 几个内容',
    ],
    'string'   => ':attribute 必须是字符',
    'timezone' => ':attribute 必须是合法的时区',
    'unique'   => ':attribute 已被注册或使用',
    'uploaded' => ':attribute 上传失败',
    'url'      => ':attribute 格式不正确',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name lines. This makes it quick to
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
    | following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name'                  => '名称',
        'username'              => '昵称',
        'email'                 => '邮箱',
        'first_name'            => '名字',
        'last_name'             => '姓氏',
        'password'              => '密码',
        'password_confirmation' => '确认密码',
        'city'                  => '城市',
        'country'               => '国家',
        'address'               => '地址',
        'phone'                 => '电话',
        'mobile'                => '手机',
        'age'                   => '年龄',
        'sex'                   => '性别',
        'gender'                => '性别',
        'year'                  => '年份',
        'month'                 => '月份',
        'day'                   => '日',
        'hour'                  => '小时',
        'minute'                => '分钟',
        'second'                => '秒',
        'title'                 => '标题',
        'content'               => '内容',
        'body'                  => '内容',
        'description'           => '简介',
        'excerpt'               => '摘录',
        'date'                  => '日期',
        'time'                  => '时间',
        'subject'               => '主题',
        'message'               => '消息',
    ],
];
