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

    'accepted' => ' :attribute لابد من الموافقه على.',
    'active_url' => ':attribute يجب ان يكون رابط فعال. ',
    'after' => ':attribute يجب ان يكون بعد من :date .',
    'after_or_equal' => ':attribute يجب ان يكون اكبر من او يساوى :date.',
    'alpha' => ':attribute يجب ان يحتوى على حروف فقط .',
    'alpha_dash' => ':attribute يجب ان يحتوى على حروف او ارقام او رموز',
    'alpha_num' => ':attribute يجب ان يحتوى على ارقام فقط',
    'array' => ':attribute يجب ان يكون من نوع array',
    'before' => 'nullable يجب ان يكون قبل :date.',
    'before_or_equal' => 'nullable يجب ان يكون قبل او يساوى :date.',
    'between' => [
        'numeric' => ':attribute يجب ان يكون بين :max و :min.',
        'file' => ':attribute يجب ان يكون بين :max و :min كيلو بايت.',
        'string' => ':attribute يجب ان يكون بين :max و :min حرف .',
        'array' => ':attribute يجب ان يكون بين :max و :min عنصر .',
    ],
    'boolean' => ':attribute يجب ان يكون صح او خطأ',
    'confirmed' => '  قيمة ال لا تتماشى مع ال:attribute تاكيد.',
    'date' => ' :attribute ليس تاريخ صحيح.',
    'date_equals' => ' :attribute يجب ان يساوى :date.',
    'date_format' => ' :attribute صيغة التاريخ غير صحيصة :format.',
    'different' => ' :attribute و :other يجب ان يكونوا مختلفين ',
    'digits' => ' :attribute يجب ان تكون :digits ارقام.',
    'digits_between' => ' :attribute يجب ان تكون بين :min , :max رقم.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => ' :attribute يجب ان يكون بريد الكترونى صحيح.',
    'ends_with' => ':attribute يجب ان ينتهوى ب :values.',
    'exists' => 'قيمة :attribute المختارة غير صحيح.',
    'file' => ' :attribute يجب ان يكون ملف.',
    'filled' => ':attribute يجب ان يحتوى على قيمة',
    'gt' => [
        'numeric' => ' :attribute يجب ان تكون اكبر من :value.',
        'file' => ' :attribute يجب ان تكون اكبر من :value كيلو بايت.',
        'string' => ' :attribute يجب ان تكون اكبر من :value حرف.',
        'array' => ' :attribute يجب ان تختار :value عنصر.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value عناصر or more.',
    ],
    'image' => ' :attribute يجب ان تكون صورة.',
    'in' => 'قيمة :attribute المختارة غير صحيحة.',
    'in_array' => ' :attribute يجب ان تكون فى  :other.',
    'integer' => ' :attribute يجب ان يكون رقم.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value عناصر.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value عناصر.',
    ],
    'max' => [
        'numeric' => ' :attribute يجب الا تكون اكبر من :max.',
        'file' => ' :attribute يجب الا تكون اكبر من :max كيلو بايت.',
        'string' => ' :attribute يجب الا تكون اكبر من :max حرف.',
        'array' => ' :attribute يجب الا تكون اكبر من  :max عناصر.',
    ],
    'mimes' => ' :attribute يجب ان تكون من نوع type: :values.',
    'mimetypes' => ' :attribute يجب ان تكون من نوع type: :values.',
    'min' => [
        'numeric' => ' :attribute يجب ان تكون على الاقل :min.',
        'file' => ' :attribute must be at least :min kilobytes.',
        'string' => ' :attribute يجب ان تكون على الاقل :min حرف.',
        'array' => ' :attribute يجب ان تكون على الاقل  :min عناصر.',
    ],
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => ' :attribute يجب ان تكون رقم.',
    'password' => ' كلمة السر غير صحيحة.',
    'present' => 'The :attribute field must be present.',
    'regex' => ' :attribute خطأ فى الادخال.',
    'required' => ' :attribute مطلوب.',
    'required_if' => ' :attribute مطلوب ',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size عناصر.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => ' :attribute يجب ان يكون حروف و ارقام.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => 'قيمة :attribute مختارة من قبل.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => ' :attribute ليس عنوان رابط صحيح.',
    'uuid' => 'The :attribute must be a valid UUID.',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
     */

    'attributes' => [
        'name' => 'اسم المستخدم',
        'email' => 'البريد الاكترونى',
        'password' => 'كلمة السر',
        'mobile' => 'الجوال',
        'phone' => 'الجوال',
        'contacts' => 'التصالات',
        'image' => 'الصورة',
        'banner' => 'الغلاف',
        'description' => 'الوصف',
        'alias' => 'عنوان url',
        'links' => 'الرابط',
        'notify_mail' => 'الموافقه على التواصل بالبريد',
        'gender_id' => 'النوع',
        'accept_terms' => 'الشروط و الاحكام',
        'comment' => 'التعليق',
        'table_name' => 'الربط',
        'type_id' => 'نوع المشاركة',
        'adv_period_id' => 'مدة الاعلان',
        'type'=>'النوع',
        'items'=>'المنتجات',
        'title'=>'العنوان',
        'url'=>'الرابط',
        'user_name'=>'الاسم',
        'bank_name'=>'اسم البنك',
        
        ''=>'',
        ''=>'',
        ''=>'',
        ''=>'',
        ''=>'',
        ''=>'',
        ''=>'',
        ''=>'',
        ''=>'',
    ],

];
