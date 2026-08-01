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

    'accepted' => 'يجب قبول حقل :attribute.',
    'accepted_if' => 'يجب قبول حقل :attribute عندما يكون :other هو :value.',
    'active_url' => 'حقل :attribute لا يشكل رابطاً صحيحاً.',
    'after' => 'يجب أن يكون :attribute تاريخاً بعد :date.',
    'after_or_equal' => 'يجب أن يكون :attribute تاريخاً يساوي أو بعد :date.',
    'alpha' => 'يجب أن يحتوي :attribute على أحرف فقط.',
    'alpha_dash' => 'يجب أن يحتوي :attribute على أحرف وأرقام وشرطات فقط.',
    'alpha_num' => 'يجب أن يحتوي :attribute على أحرف وأرقام فقط.',
    'any_of' => 'حقل :attribute غير صحيح.',
    'array' => 'يجب أن يكون :attribute مصفوفة.',
    'ascii' => 'يجب أن يحتوي :attribute على رموز وأحرف إنجليزية مفردة فقط.',
    'before' => 'يجب أن يكون :attribute تاريخاً قبل :date.',
    'before_or_equal' => 'يجب أن يكون :attribute تاريخاً يساوي أو قبل :date.',
    'between' => [
        'array' => 'يجب أن يحتوي :attribute على عدد عناصر بين :min و :max.',
        'file' => 'يجب أن يكون حجم :attribute بين :min و :max كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
        'string' => 'يجب أن يكون عدد أحرف :attribute بين :min و :max.',
    ],
    'boolean' => 'حقل :attribute يجب أن يكون صح أو خطأ.',
    'can' => 'حقل :attribute يحتوي على قيمة غير مصرح بها.',
    'confirmed' => 'تأكيد :attribute غير مطابق.',
    'contains' => 'حقل :attribute يفتقد لقيمة مطلوبة.',
    'current_password' => 'كلمة المرور غير صحيحة.',
    'date' => 'حقل :attribute ليس تاريخاً صحيحاً.',
    'date_equals' => 'يجب أن يكون :attribute تاريخاً مطابقاً لـ :date.',
    'date_format' => 'حقل :attribute لا يتوافق مع الصيغة :format.',
    'decimal' => 'يجب أن يحتوي :attribute على :decimal خانة عشرية.',
    'declined' => 'يجب رفض حقل :attribute.',
    'declined_if' => 'يجب رفض حقل :attribute عندما يكون :other هو :value.',
    'different' => 'يجب أن يكون حقل :attribute مختلفاً عن :other.',
    'digits' => 'يجب أن يتكون :attribute من :digits أرقام.',
    'digits_between' => 'يجب أن يتكون :attribute من أرقام بين :min و :max.',
    'dimensions' => 'أبعاد صورة :attribute غير صحيحة.',
    'distinct' => 'حقل :attribute يحتوي على قيمة مكررة.',
    'doesnt_contain' => 'يجب ألا يحتوي :attribute على أي من القيم التالية: :values.',
    'doesnt_end_with' => 'يجب ألا ينتهي :attribute بأحد القيم التالية: :values.',
    'doesnt_start_with' => 'يجب ألا يبدأ :attribute بأحد القيم التالية: :values.',
    'email' => 'صيغة :attribute غير صحيحة.',
    'encoding' => 'يجب أن يكون ترميز :attribute هو :encoding.',
    'ends_with' => 'يجب أن ينتهي :attribute بأحد القيم التالية: :values.',
    'enum' => 'قيمة :attribute المختارة غير صالحة.',
    'exists' => ':attribute المحدد غير موجود.',
    'extensions' => 'يجب أن يكون امتداد ملف :attribute أحد الامتدادات التالية: :values.',
    'file' => 'يجب أن يكون :attribute ملفاً.',
    'filled' => 'حقل :attribute إجباري ولا يمكن تركه فارغاً.',
    'gt' => [
        'array' => 'يجب أن يحتوي :attribute على أكثر من :value عناصر.',
        'file' => 'يجب أن يكون حجم :attribute أكبر من :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute أكبر من :value.',
        'string' => 'يجب أن يتجاوز طول :attribute :value أحرف.',
    ],
    'gte' => [
        'array' => 'يجب أن يحتوي :attribute على :value عناصر أو أكثر.',
        'file' => 'يجب أن يكون حجم :attribute أكبر من أو يساوي :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute أكبر من أو تساوي :value.',
        'string' => 'يجب أن يكون طول :attribute أكبر من أو يساوي :value أحرف.',
    ],
    'hex_color' => 'يجب أن يكون :attribute رمز لون هكسا ديسيمال صحيح.',
    'image' => 'يجب أن يكون :attribute صورة.',
    'in' => ':attribute المختار غير صحيح.',
    'in_array' => 'حقل :attribute غير موجود في :other.',
    'in_array_keys' => 'يجب أن يحتوي :attribute على أحد المفاتيح التالية: :values.',
    'integer' => 'يجب أن يكون :attribute رقماً صحيحاً.',
    'ip' => 'يجب أن يكون :attribute عنوان IP صحيحاً.',
    'ipv4' => 'يجب أن يكون :attribute عنوان IPv4 صحيحاً.',
    'ipv6' => 'يجب أن يكون :attribute عنوان IPv6 صحيحاً.',
    'json' => 'يجب أن يكون :attribute نصاً بنسق JSON صحيح.',
    'list' => 'يجب أن يكون حقل :attribute قائمة.',
    'lowercase' => 'يجب أن تكون أحرف :attribute صغيرة.',
    'lt' => [
        'array' => 'يجب أن يحتوي :attribute على أقل من :value عناصر.',
        'file' => 'يجب أن يكون حجم :attribute أقل من :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute أقل من :value.',
        'string' => 'يجب أن يكون طول :attribute أقل من :value أحرف.',
    ],
    'lte' => [
        'array' => 'يجب ألا يحتوي :attribute على أكثر من :value عناصر.',
        'file' => 'يجب أن يكون حجم :attribute أقل من أو يساوي :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute أقل من أو تساوي :value.',
        'string' => 'يجب أن يكون طول :attribute أقل من أو يساوي :value أحرف.',
    ],
    'mac_address' => 'يجب أن يكون :attribute عنوان MAC صحيحاً.',
    'max' => [
        'string' => 'يجب أن لا يتجاوز :attribute عن :max حرف.',
        'numeric' => 'يجب أن لا يتجاوز :attribute عن :max.',
        'array' => 'يجب ألا يحتوي :attribute على أكثر من :max عناصر.',
        'file' => 'يجب ألا يتجاوز حجم :attribute :max كيلوبايت.',
    ],
    'max_digits' => 'يجب ألا يحتوي :attribute على أكثر من :max أرقام.',
    'mimes' => 'صيغة :attribute يجب أن تكون: :values.',
    'mimetypes' => 'نوع ملف :attribute يجب أن يكون: :values.',
    'min' => [
        'string' => 'يجب أن لا يقل :attribute عن :min أحرف.',
        'numeric' => 'يجب أن لا يقل :attribute عن :min.',
        'array' => 'يجب أن يحتوي :attribute على :min عناصر على الأقل.',
        'file' => 'يجب ألا يقل حجم :attribute عن :min كيلوبايت.',
    ],
    'min_digits' => 'يجب أن يحتوي :attribute على :min أرقام على الأقل.',
    'missing' => 'يجب أن يكون حقل :attribute مفقوداً.',
    'missing_if' => 'يجب أن يكون حقل :attribute مفقوداً عندما يكون :other هو :value.',
    'missing_unless' => 'يجب أن يكون حقل :attribute مفقوداً إلا إذا كان :other هو :value.',
    'missing_with' => 'يجب أن يكون حقل :attribute مفقوداً عند وجود :values.',
    'missing_with_all' => 'يجب أن يكون حقل :attribute مفقوداً عند وجود جميع :values.',
    'multiple_of' => 'يجب أن يكون :attribute مضاعفاً للقيمة :value.',
    'not_in' => 'الخيار المختار لـ :attribute غير صالحة.',
    'not_regex' => 'صيغة :attribute غير صالحة.',
    'numeric' => 'يجب أن يكون :attribute رقماً.',
    'password' => [
        'letters' => 'يجب أن تحتوي :attribute على حرف واحد على الأقل.',
        'mixed' => 'يجب أن تحتوي :attribute على حرف كبير وحرف صغير على الأقل.',
        'numbers' => 'يجب أن تحتوي :attribute على رقم واحد على الأقل.',
        'symbols' => 'يجب أن تحتوي :attribute على رمز واحد على الأقل.',
        'uncompromised' => ':attribute المخلة تم تسريبها في مخترقات سابقة، يرجى اختيار :attribute أخرى.',
    ],
    'present' => 'يجب توفر حقل :attribute.',
    'present_if' => 'يجب توفر حقل :attribute عندما يكون :other هو :value.',
    'present_unless' => 'يجب توفر حقل :attribute إلا إذا كان :other هو :value.',
    'present_with' => 'يجب توفر حقل :attribute عند توفر :values.',
    'present_with_all' => 'يجب توفر حقل :attribute عند توفر جميع :values.',
    'prohibited' => 'حقل :attribute محظور.',
    'prohibited_if' => 'حقل :attribute محظور عندما يكون :other هو :value.',
    'prohibited_if_accepted' => 'حقل :attribute محظور عندما يكون :other مقبولاً.',
    'prohibited_if_declined' => 'حقل :attribute محظور عندما يكون :other مرفوضاً.',
    'prohibited_unless' => 'حقل :attribute محظور إلا إذا كان :other في :values.',
    'prohibits' => 'حقل :attribute يمنع توفر :other.',
    'regex' => 'صيغة :attribute غير صالحة.',
    'required' => 'حقل :attribute مطلوب.',
    'required_array_keys' => 'يجب أن يحتوي :attribute على عناصر للمفاتيح التالي: :values.',
    'required_if' => 'حقل :attribute مطلوب عندما يكون :other هو :value.',
    'required_if_accepted' => 'حقل :attribute مطلوب عند قبول :other.',
    'required_if_declined' => 'حقل :attribute مطلوب عند رفض :other.',
    'required_unless' => 'حقل :attribute مطلوب إلا إذا كان :other ضمن :values.',
    'required_with' => 'حقل :attribute مطلوب عند توفر :values.',
    'required_with_all' => 'حقل :attribute مطلوب عند توفر جميع :values.',
    'required_without' => 'حقل :attribute مطلوب عند عدم توفر :values.',
    'required_without_all' => 'حقل :attribute مطلوب عند عدم توفر أي من :values.',
    'same' => 'يجب أن يتطابق :attribute مع :other.',
    'size' => [
        'array' => 'يجب أن يحتوي :attribute على :size عناصر.',
        'file' => 'يجب أن يكون حجم :attribute :size كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute :size.',
        'string' => 'يجب أن يتكون :attribute من :size أحرف.',
    ],
    'starts_with' => 'يجب أن يبدأ :attribute بأحد القيم التالية: :values.',
    'string' => 'يجب أن يكون :attribute نصاً.',
    'timezone' => 'يجب أن يكون :attribute نطاقاً زمنياً صحيحاً.',
    'unique' => ':attribute مستخدم من قبل.',
    'uploaded' => 'فشل تحميل :attribute.',
    'uppercase' => 'يجب أن تكون أحرف :attribute كبيرة.',
    'url' => 'صيغة رابط :attribute غير صحيحة.',
    'ulid' => 'يجب أن يكون :attribute معرف ULID صحيحاً.',
    'uuid' => 'يجب أن يكون :attribute معرف UUID صحيحاً.',

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
        'password' => [
            'min'        => 'يجب أن تحتوي كلمة المرور على 8 خانات على الأقل وتتضمن أحرفاً كبيرة وصغيرة وأرقاماً ورُموزاً.',
            'mixed_case' => 'يجب أن تحتوي كلمة المرور على 8 خانات على الأقل وتتضمن أحرفاً كبيرة وصغيرة وأرقاماً ورُموزاً.',
            'numbers'    => 'يجب أن تحتوي كلمة المرور على 8 خانات على الأقل وتتضمن أحرفاً كبيرة وصغيرة وأرقاماً ورُموزاً.',
            'symbols'    => 'يجب أن تحتوي كلمة المرور على 8 خانات على الأقل وتتضمن أحرفاً كبيرة وصغيرة وأرقاماً ورُموزاً.',
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
        'username'        => 'اسم المستخدم',
        'full_name'       => 'الاسم الكامل',
        'email'           => 'البريد الإلكتروني',
        'password'        => 'كلمة المرور',
        'phone'           => 'رقم الجوال',
        'national_id'     => 'رقم الهوية الوطنية',
        'city'            => 'المدينة',
        'neighborhood'    => 'الحي',
        'street'          => 'الشارع',
        'building_number' => 'رقم المبنى',
        'location_link'   => 'رابط الموقع',
        'service_id'      => 'الخدمة',
        'avatar'          => 'الصورة الشخصية',
        'login'           => 'اسم المستخدم أو رقم الجوال',
        'status'          => 'الحالة',
    ],

];