<?php

return [
    'return_rule_on_failure' => [
        /*
         * Parameter configs
         * Not contain prefix in return configs
         */
        "parameters" => [
            "include_in_return" => false,
            // Include param. Ex: unique:users,id
            "include" => [],
            // Not include param list. Ex: unique:users,id => unique:
            "exclude" => [
                'unique',
            ],
        ],

        /*
         * Value configs
         * Not contain prefix in return configs
         */
        "value" => [
            "include_in_return" => false,

            /*
             * If empty, all output will include value (except items in exclude)
             * E.g. With "unique" in include
             * unique:users,id:1 => unique:users,id:
             */
            "include" => [],

            /*
             * If empty, all output will include value (except items in exclude)
             * E.g. With "unique" in exclude
             * unique:users,id:1 => unique::1
             */
            "exclude" => [],
        ],

        "return" => [
            /*
             * Return default validation rule name
             * As Laravel return namespace of custom validation class
             * E.g. app/rules/unique => unique
             */
            "full_rule_name" => false,

            /*
             * Merge failed array validation as field name
             * E.g. select.1, select.2 => select
             */
            "merge_array_validation" => true,

            /*
             * Prefix for rule name
             * E.g. "prefix = validation."
             * unique => validation.unique
             */
            "prefix" => '',

            /*
             * Separator for each item
             * E.g. For "attribute = :" and "parameter = ,"
             * unique:users,id:1
             */
            "separator" => [
                "attribute" => ':',
                "parameter" => ',',
            ],

            /*
             * Just return the first failed validation
             * true: return the first error, false: return an array with multiple errors
             */
            "return_first_error_only" => false,

            /*
             * Return type of each failed validation
             * Supported: "string", "array"
             */
            "return_type" => "string",

            /*
             * HTTP status code when validate failed
             */
            "status_code" => 422,
        ],
    ],
];
