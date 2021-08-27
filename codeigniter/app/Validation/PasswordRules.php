<?php
namespace App\Validation;

class PasswordRules{

  // Rule is to validate mobile number digits
  public function strong_password(string $password, string &$error = null){
    
    $password = trim($password);

		$regex_lowercase = '/[a-z]/';
		$regex_uppercase = '/[A-Z]/';
		$regex_number = '/[0-9]/';
		$regex_special = '/[!@#$%^&*()\-_=+{};:,<.>ยง~]/';

		if (empty($password))
		{
			$error = 'The password field is required.';

			return FALSE;
		}

		if (preg_match_all($regex_lowercase, $password) < 1)
		{
			$error = 'The password field must be at least one lowercase letter.';

			return FALSE;
		}

		if (preg_match_all($regex_uppercase, $password) < 1)
		{
			$error =  'The password field must be at least one uppercase letter.';

			return FALSE;
		}

		if (preg_match_all($regex_number, $password) < 1)
		{
			$error = 'The password field must have at least one number.';

			return FALSE;
		}

		if (preg_match_all($regex_special, $password) < 1)
		{
			$error = 'The passsword field must have at least one special character.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>ยง~');

			return FALSE;
		}

		if (strlen($password) < 8)
		{
			$error  = 'The password field must be at least 8 characters in length.';

			return FALSE;
		}

		if (strlen($password) > 32)
		{
			$error = 'The {field} field cannot exceed 32 characters in length.';

			return FALSE;
		}

		return TRUE;
  }
}