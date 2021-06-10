<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
	public $product = [
		'category_id'           => 'required',
		'product_name'          => 'required',
		'product_price'         => 'required',
		'product_sku'           => 'required',
		'product_status'        => 'required',
		'product_image'         => 'uploaded[product_image]|mime_in[product_image,image/jpg,image/jpeg,image/gif,image/png]|max_size[product_image,1000]',
		'product_description'   => 'required'
	];
	 
	public $product_errors = [
		'category_id'   => [
			'required'  => 'Nama category wajib diisi.',
		],
		'product_name'  => [
			'required'  => 'Nama product wajib diisi.'
		],
		'product_price' => [
			'required'  => 'Harga product wajib diisi.'
		],
		'product_sku'   => [
			'required'  => 'Kode product wajib diisi.'
		],
		'product_status'=> [
			'required'  => 'Status product wajib diisi.'
		],
		'product_image'=> [
			'mime_in'   => 'Gambar product hanya boleh diisi dengan jpg, jpeg, png atau gif.',
			'max_size'  => 'Gambar product maksimal 1mb',
			'uploaded'  => 'Gambar product wajib diisi'
		],
		'product_description'   => [
			'required'          => 'Description product wajib diisi.'
		]
	];
}
