<?php

namespace App\Helpers;
use Illuminate\Support\Arr;

class CoreHelper
{

	public static function make_folder($folder)
	{

      if( File::makeDirectory($folder, 0777,true))
          {return true;}

      return false;
  }


	public static function delete_file($path){
			if (file_exists($path)) {
					File::delete($path);
			}
			return true;
	}



	public static function generateRandomString($length)
	{
			// $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			// $charactersLength = strlen($characters);
			// $randomString = '';
			// for ($i = 0; $i < $length; $i++) {
			// 		$randomString .= $characters[rand(0, $charactersLength - 1)];
			// }
			// return $randomString;

				$allowedCharacters = 'abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890'; // !$%^&#!$%^&#
				$random = str_shuffle($allowedCharacters);
				$randomString = substr($random, 0, $length);

				if (is_bool($randomString) || empty($randomString)) {
					$randomString = \Illuminate\Support\Str::random($length);
				}

				return $randomString;

	}


	function isConnected()
	{
	    $connected = @fsockopen("www.google.com", 80);
	    if ($connected) {
	        fclose($connected);
	        return true;
	    }

	    return false;
	}


	public static function shortLink($refType,$refId,$alies)
	{
			$newRnd="";
			do
			{
					$newRnd="s9".Helper::generateRandomString(12);
					$found=redir:: where('last_alias',$newRnd)->first();
			}
			while(!empty($found));

			$redir=new redir();
			$redir->old_alias=$newRnd;
			$redir->ref_type=$refType;
			$redir->ref_Id=$refId;
			$redir->last_alias=$alies;
			$redir->save();

			if (!$redir)
			{return "error creating Short Link";}
			else
			{return 0;}

	}

	function getVar($list)
	{
		// Used to get value-list json
	 // *  @return array
	    $file = resource_path('var/'.$list.'.json');

	    return (\File::exists($file)) ? json_decode(file_get_contents($file), true) : [];
	}


	function beginTransaction() {
	    \DB::beginTransaction();
	}

	function rollBackTransaction() {
	    \DB::rollBack();
	}

	function commitTransaction() {
	    \DB::commit();
	}


}




// ??????????????????????????????/ important
// public static function setLocal()
// {
// 	 solution for fornt ????????????????
// 	 dd(Request::segment(1).'wwwww');
// 	 return 'en';
// }


// run artisan command core.php
// Prepare to run (5 seconds for $timeout)
// $timeout = 5;
// $start = time();
//
// // Actually call the Artisan command
// $exitCode = \Artisan::call('config:cache');
//
// // Check if Artisan call is done
// while (true) {
// 	// Just finish if timeout
// 	if (time() - $start >= $timeout) {
// 		echo "Timeout\n";
// 		break;
// 	}




// migrate with command cor.php
// function artisanMigrate()
// {
// 	$exitCode = \Artisan::call('migrate', ["--force" => true]);
//
// 	return $exitCode;
// }





// core.php
// /**
//  * Redirect (Prevent Browser cache)
//  *
//  * @param $url
//  * @param int $code (301 => Moved Permanently | 302 => Moved Temporarily)
//  */
// function headerLocation($url, $code = 301)
// {
// 	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
// 	header("Cache-Control: post-check=0, pre-check=0", false);
// 	header("Pragma: no-cache");
// 	header("Location: " . $url, true, $code);
// 	exit();
// }


// core.php
// function strToInt($value)
// {
// 	$value = preg_replace('/[^0-9]/', '', $value);
// 	$value = (int)$value;
//
// 	return $value;
// }




// core.php
// function getRandomPassword($length)
// {

// }





// exp/helper
// function for numberToWord
// function for dateToWord
// function for currencyInWord


// exp/core.php
// function hidePartOfEmail($value, $escapedChars = 1)
// {
// 	$atPos = mb_stripos($value, '@');
// 	if ($atPos === false) {
// 		return $value;
// 	}
//
// 	$emailUsername = mb_substr($value, 0, $atPos);
// 	$emailDomain = mb_substr($value, ($atPos + 1));
//
// 	if (!empty($emailUsername) && !empty($emailDomain)) {
// 		$value = hidePartOfString($emailUsername, $escapedChars) . '@' . $emailDomain;
// 	}
//
// 	return $value;
// }





/**
 * Get default max file upload size (from PHP.ini)
 *
 * @return mixed
 */
// function maxUploadSize()
// {
// 	$maxUpload = (int)(ini_get('upload_max_filesize'));
// 	$maxPost = (int)(ini_get('post_max_size'));
//
// 	return min($maxUpload, $maxPost);
// }







/**
 * Escape JSON string
 *
 * Escape this:
 * \b  Backspace (ascii code 08)
 * \f  Form feed (ascii code 0C)
 * \n  New line
 * \r  Carriage return
 * \t  Tab
 * \"  Double quote
 * \\  Backslash caracter
 *
 * @param $value
 * @return mixed
 */
// function escapeJsonString($value)
// {
// 	// list from www.json.org: (\b backspace, \f formfeed)
// 	$escapers = ["\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c"];
// 	$replacements = ["\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b"];
// 	$value = str_replace($escapers, $replacements, trim($value));
//
// 	return $value;
// }
