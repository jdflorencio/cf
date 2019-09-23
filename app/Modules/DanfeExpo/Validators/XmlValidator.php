<?php

namespace App\Modules\DanfeExpo\Validators;

// use App\Exceptions\InputValidationException;
use Validator;
use Exception;

class XmlValidator
{
	/**
	 * Executa a validação dos arquivos
	 * @param  array  $data 
	 * @return void       
	 */
	public function validate(array $data) : void
	{
		$validator = Validator::make($data, $this->rules($data), $this->messages());
		// dd($validator>fails());
		if ($validator->fails()) {
			$failedRules = $validator->failed();
			// return ["erro" => "arquivo não suportado"];
			dd('error');
        }
	}

	/**
	 * Tipos de arquivos aceitos
	 * @param  array  $data 
	 * @return array       
	 */
	public function rules(array $data) : array
	{
		$rules = [
			'file' => 'required|mimes:xml|max:20000'
		];

		return $rules;
	}

	/**
	 * Menssagem da validação
	 * @return array 
	 */
	public function messages() : array
	{
		return [
			'imagem' => 'o aruivo é obrigatorio',
		];
	}
}