<?php

$menus = [

    [
        "url" => "/",
        "title" => trans("homepage"),
        "icon" => "si si-cup",
        "permissions" => [
            "show" => trans("show")
        ]

    ],
    [
        "url" => "users",
        "title" => trans("users"),
        "icon" => "si si-users",
        "permissions" => [
            "show" => trans("show"),
            "edit" => trans("edit"),
            "add" => trans("add"),
            "delete" => trans("delete")
        ]
    ],
    [
        "url" => "settings",
        "title" => trans("settings"),
        "icon" => "si si-settings",
        "permissions" => [
            "show" => trans("show"),
            "edit" => trans("edit")
        ],
        "submenu" => [
            [
                "url" => "settings",
                "title" => trans("general_setting"),

            ],
            [
                "url" => "email_settings",
                "title" => trans("email_list"),
                "permissions" => [
                    "show" => trans("show"),
                    "edit" => trans("edit"),
                    "add" => trans("add"),
                    "delete" => trans("delete")
                ]
            ],
            [
                "url" => "email_templates",
                "title" => trans("email_templates"),
                "permissions" => [
                    "show" => trans("show"),
                    "edit" => trans("edit")
                ]
            ],
            [
                "url" => "languages",
                "title" => trans("language_list"),
                "permissions" => [
                    "show" => trans("show"),
                    "edit" => trans("edit"),
                    "add" => trans("add"),
                    "delete" => trans("delete")
                ]
            ]
        ]
    ],
    [
        "url" => "services",
        "title" => trans("service_list"),
        "icon" => "si si-wrench",
        "permissions" => [
            "show" => trans("show"),
            "edit" => trans("edit"),
            "add" => trans("add"),
            "delete" => trans("delete")
        ]
    ],
    [
        "url" => "products",
        "title" => trans("product_list"),
        "icon" => "si si-handbag",
        "permissions" => [
            "show" => trans("show"),
            "edit" => trans("edit"),
            "add" => trans("add"),
            "delete" => trans("delete")
        ]
    ],
    [
        "url" => "customers",
        "title" => trans("customer_list"),
        "icon" => "si si-briefcase",
        "permissions" => [
            "show" => trans("show"),
            "edit" => trans("edit"),
            "add" => trans("add"),
            "delete" => trans("delete"),
            "activities" => trans("summary")
        ]
    ],
    [
        "url" => "suppliers",
        "title" => trans("supplier_list"),
        "icon" => "si si-basket",
        "permissions" => [
            "show" => trans("show"),
            "edit" => trans("edit"),
            "add" => trans("add"),
            "delete" => trans("delete"),
            "activities" => trans("summary")
        ]
    ],
    [
        "url" => "accounts",
        "title" => trans("account_list"),
        "icon" => "fa fa-bank",
        "permissions" => [
            "show" => trans("show"),
            "edit" => trans("edit"),
            "add" => trans("add"),
            "delete" => trans("delete")
        ],
        "submenu" => [
            [
                "url" => "accounts",
                "title" => trans("account_list")
            ],
            [
                "url" => "account_types",
                "title" => trans("account_types"),
                "permissions" => [
                    "show" => trans("show"),
                    "edit" => trans("edit"),
                    "add" => trans("add"),
                    "delete" => trans("delete")
                ]
            ]
        ]
    ],
    [
        "url" => "incomes",
        "title" => trans("income_list"),
        "icon" => "si si-plus",
        "permissions" => [
            "show" => trans("show"),
            "edit" => trans("edit"),
            "add" => trans("add"),
            "delete" => trans("delete")
        ],
        "submenu" => [
            [
                "url" => "incomes",
                "title" => trans("income_list")
            ],
            [
                "url" => "income_category",
                "title" => trans("income_types"),
                "permissions" => [
                    "show" => trans("show"),
                    "edit" => trans("edit"),
                    "add" => trans("add"),
                    "delete" => trans("delete")
                ]
            ]
        ]
    ],
    [
        "url" => "expenses",
        "title" => trans("expense_list"),
        "icon" => "si si-minus",
        "permissions" => [
            "show" => trans("show"),
            "edit" => trans("edit"),
            "add" => trans("add"),
            "delete" => trans("delete")
        ],
        "submenu" => [
            [
                "url" => "expenses",
                "title" => trans("expense_list")
            ],
            [
                "url" => "expense_category",
                "title" => trans("expense_types"),
                "permissions" => [
                    "show" => trans("show"),
                    "edit" => trans("edit"),
                    "add" => trans("add"),
                    "delete" => trans("delete")
                ]
            ]
        ]
    ],
    [
        "url" => "invoices",
        "title" => trans("invoices"),
        "icon" => "si si-docs",
        "permissions" => [
            "show" => trans("show"),
            "edit" => trans("edit"),
            "add" => trans("add"),
            "delete" => trans("delete")
        ],
        "submenu" => [
            [
                "url" => "invoices",
                "title" => trans("invoice_list")
            ],
            [
                "url" => "bills",
                "title" => trans("bill_list"),
                "permissions" => [
                    "show" => trans("show"),
                    "edit" => trans("edit"),
                    "add" => trans("add"),
                    "delete" => trans("delete")
                ]
            ]
        ]
    ],
    [
        "url" => "forward_transactions",
        "title" => trans("forward_transactions"),
        "icon" => "si si-calendar",
        "permissions" => [
            "show" => trans("show"),
            "edit" => trans("edit"),
            "add" => trans("add"),
            "delete" => trans("delete")
        ]
    ]

];