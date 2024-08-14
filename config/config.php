<?php
// <!-- cấu hình mặc đinh các từ khóa  -->

return [
    'payment' => [
        'status' => [
            0 => [
                'vi' => 'Thanh toán đang chờ xử lý',
                'en' => 'Payment is pending',
                'fr' => 'Le paiement est en attente',

            ],
            1 => [
                'vi' => 'Thanh toán thành công',
                'en' => 'Payment successful',
                'fr' => 'Paiement réussi',
            ],
            2 => [
                'vi' => 'Thanh toán thất bại',
                'en' => 'Payment failed',
                'fr' => 'Paiement échoué',
            ],
            3 => [
                'vi' => 'Thanh toán bị hủy',
                'en' => 'Payment is canceled',
                'fr' => 'Le paiement est annulé',
            ],
        ],
    ],
    'product' => [
        'price' => [
            'vi' => 'Giá',
            'en' => 'Price',
            'fr' => 'Prix',
        ],
        'quantity' => [
            'vi' => 'Số lượng',
            'en' => 'Quantity',
            'fr' => 'Quantité',
        ],
        'total' => [
            'vi' => 'Tổng tiền',
            'en' => 'Total',
            'fr' => 'Total',
        ],
        'unit' => [
            'vi' => 'VNĐ',
            'en' => 'USD',
            'fr' => 'EUR',
        ],
        'name' => [
            'vi' => 'Tên sản phẩm',
            'en' => 'Product name',
            'fr' => 'Nom du produit',
        ],
    ]
];
