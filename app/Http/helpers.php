<?php

/**
 * Formats a phone number
 *
 * Returns a human readable phone number.
 *
 * @param string $number
 * @param string $country_code
 * @return string
 */
function formatPhoneNumber($number, $country_code = false)
{
    $formatted = "(" . substr($number, 0, 3) . ") " . substr($number, 3, 3) . "-" . substr($number, 6);
    if ($country_code) $formatted = '+' . $country_code . ' ' . $formatted;
    return $formatted;
}

/**
 * Generate an API Secret
 *
 * Generates a unique API secret
 *
 * @param int $min_length
 * @param int $max_length
 * @return mixed|string
 */
function generateApiSecret($min_length = 12, $max_length = 64)
{
    do {
        $length = (int)rand($min_length, $max_length);
        $token = strtoupper(Illuminate\Support\Str::random($length)); // Generate a token with the chosen length
        if (strpos($token, 'O') !== false) $token = str_replace('O', '0', $token);
        $secret_exists = \App\Model\User::where('api_secret', $token)->first(); // Get any accounts where that token is
    } while ($secret_exists);
    return $token;
}

/**
 * Generate a Verification Token
 *
 * Generates a unique token for phone and email verifications.
 *
 * @param int $min_length
 * @param int $max_length
 * @return mixed|string
 */
function generateVerificationToken($min_length = 3, $max_length = 6)
{
    do {
        $exists = false;
        $length = (int)rand($min_length, $max_length);
        $token = strtoupper(Illuminate\Support\Str::random($length)); // Generate a token with the chosen length
        if (strpos($token, 'O') !== false) $token = str_replace('O', '0', $token);
        $email_exist = App\Model\Email::where('verification_token', $token)->first(); // Get any emails with that token
        $phone_exists = App\Model\MobilePhone::where('verification_token', $token)->first(); // Get any phones with that token
        if (!empty($email_exist) || !empty($phone_exists)) $exists = true;
    } while ($exists);
    return $token;
}

/**
 * Verifies a resource with token
 *
 * Verifies phone numbers and emails via the token passed in.
 *
 * @param $token
 * @return bool
 */
function verifyToken($token)
{
    $email = App\Model\Email::where('verification_token', $token)->first(); // Get any emails with that token
    $phone = App\Model\MobilePhone::where('verification_token', $token)->first(); // Get any phones with that token

    if (!empty($email) && !empty($phone)) {
        abort(500, 'Duplicate Token Exception!');
    } elseif (!empty($email)) {
        $email->verification_token = null;
        $email->verified = true;
        $email->save();
        return $email;
    } elseif (!empty($phone)) {
        $phone->verification_token = null;
        $phone->verified = true;
        $phone->save();
        return $phone;
    } else {
        return false;
    }
}

/**
 * Returns an array of countries
 *
 * This is used to pre-seed the database with production data.
 *
 * @return array
 */
function countryList()
{
    $now = Carbon\Carbon::now('utc')->toDateTimeString();

    return [
        ['label' => 'Afghanistan', 'code' => 'AFG', 'abbreviation' => 'AF', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Albania', 'code' => 'ALB', 'abbreviation' => 'AL', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Algeria', 'code' => 'DZA', 'abbreviation' => 'DZ', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'American Samoa', 'code' => 'ASM', 'abbreviation' => 'AS', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Andorra', 'code' => 'AND', 'abbreviation' => 'AD', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Angola', 'code' => 'AGO', 'abbreviation' => 'AO', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Anguilla', 'code' => 'AIA', 'abbreviation' => 'AI', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Antarctica', 'code' => 'ATA', 'abbreviation' => 'AQ', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Antigua and Barbuda', 'code' => 'ATG', 'abbreviation' => 'AG', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Argentina', 'code' => 'ARG', 'abbreviation' => 'AR', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Armenia', 'code' => 'ARM', 'abbreviation' => 'AM', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Aruba', 'code' => 'ABW', 'abbreviation' => 'AW', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Australia', 'code' => 'AUS', 'abbreviation' => 'AU', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Austria', 'code' => 'AUT', 'abbreviation' => 'AT', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Azerbaijan', 'code' => 'AZE', 'abbreviation' => 'AZ', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Bahamas', 'code' => 'BHS', 'abbreviation' => 'BS', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Bahrain', 'code' => 'BHR', 'abbreviation' => 'BH', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Bangladesh', 'code' => 'BGD', 'abbreviation' => 'BD', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Barbados', 'code' => 'BRB', 'abbreviation' => 'BB', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Belarus', 'code' => 'BLR', 'abbreviation' => 'BY', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Belgium', 'code' => 'BEL', 'abbreviation' => 'BE', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Belize', 'code' => 'BLZ', 'abbreviation' => 'BZ', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Benin', 'code' => 'BEN', 'abbreviation' => 'BJ', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Bermuda', 'code' => 'BMU', 'abbreviation' => 'BM', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Bhutan', 'code' => 'BTN', 'abbreviation' => 'BT', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Bolivia', 'code' => 'BOL', 'abbreviation' => 'BO', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Bosnia-Herzegovina', 'code' => 'BIH', 'abbreviation' => 'BA', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Botswana', 'code' => 'BWA', 'abbreviation' => 'BW', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Bouvet Island', 'code' => 'BVT', 'abbreviation' => 'BV', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Brazil', 'code' => 'BRA', 'abbreviation' => 'BR', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'British Indian Ocean Territory', 'code' => 'IOT', 'abbreviation' => 'IO', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Brunei Darussalam', 'code' => 'BRN', 'abbreviation' => 'BN', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Bulgaria', 'code' => 'BGR', 'abbreviation' => 'BG', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Burkina Faso', 'code' => 'BFA', 'abbreviation' => 'BF', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Burundi', 'code' => 'BDI', 'abbreviation' => 'BI', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Cambodia', 'code' => 'KHM', 'abbreviation' => 'KH', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Cameroon', 'code' => 'CMR', 'abbreviation' => 'CM', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Canada', 'code' => 'CAN', 'abbreviation' => 'CA', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Cape Verde', 'code' => 'CPV', 'abbreviation' => 'CV', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Cayman Islands', 'code' => 'CYM', 'abbreviation' => 'KY', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Central African Republic', 'code' => 'CAF', 'abbreviation' => 'CF', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Chad', 'code' => 'TCD', 'abbreviation' => 'TD', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Chile', 'code' => 'CHL', 'abbreviation' => 'CL', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'China', 'code' => 'CHN', 'abbreviation' => 'CN', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Christmas Island', 'code' => 'CXR', 'abbreviation' => 'CX', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Cocos (Keeling) Islands', 'code' => 'CCK', 'abbreviation' => 'CC', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Colombia', 'code' => 'COL', 'abbreviation' => 'CO', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Comoros', 'code' => 'COM', 'abbreviation' => 'KM', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Congo', 'code' => 'COG', 'abbreviation' => 'CG', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Congo, Democratic Republic of', 'code' => 'COD', 'abbreviation' => 'CD', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Cook Islands', 'code' => 'COK', 'abbreviation' => 'CK', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Costa Rica', 'code' => 'CRI', 'abbreviation' => 'CR', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Cote D\'Ivoire', 'code' => 'CIV', 'abbreviation' => 'CI', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Croatia (Hrvatska)', 'code' => 'HRV', 'abbreviation' => 'HR', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Cuba', 'code' => 'CUB', 'abbreviation' => 'CU', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Cyprus', 'code' => 'CYP', 'abbreviation' => 'CY', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Czech Republic', 'code' => 'CZE', 'abbreviation' => 'CZ', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Denmark', 'code' => 'DNK', 'abbreviation' => 'DK', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Djibouti', 'code' => 'DJI', 'abbreviation' => 'DJ', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Dominica', 'code' => 'DMA', 'abbreviation' => 'DM', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Dominican Republic', 'code' => 'DOM', 'abbreviation' => 'DO', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'East Timor', 'code' => 'TMP', 'abbreviation' => 'TP', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Ecuador', 'code' => 'ECU', 'abbreviation' => 'EC', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Egypt', 'code' => 'EGY', 'abbreviation' => 'EG', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'El Salvador', 'code' => 'SLV', 'abbreviation' => 'SV', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Equatorial Guinea', 'code' => 'GNQ', 'abbreviation' => 'GQ', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Eritrea', 'code' => 'ERI', 'abbreviation' => 'ER', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Estonia', 'code' => 'EST', 'abbreviation' => 'EE', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Ethiopia', 'code' => 'ETH', 'abbreviation' => 'ET', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Falkland Islands (Malvinas)', 'code' => 'FLK', 'abbreviation' => 'FK', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Faroe Islands', 'code' => 'FRO', 'abbreviation' => 'FO', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Fiji', 'code' => 'FJI', 'abbreviation' => 'FJ', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Finland', 'code' => 'FIN', 'abbreviation' => 'FI', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'France', 'code' => 'FRA', 'abbreviation' => 'FR', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'French Guiana', 'code' => 'GUF', 'abbreviation' => 'GF', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'French Polynesia', 'code' => 'PYF', 'abbreviation' => 'PF', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'French Southern Territories', 'code' => 'ATF', 'abbreviation' => 'TF', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Gabon', 'code' => 'GAB', 'abbreviation' => 'GA', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Gambia', 'code' => 'GMB', 'abbreviation' => 'GM', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Georgia', 'code' => 'GEO', 'abbreviation' => 'GE', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Germany', 'code' => 'DEU', 'abbreviation' => 'DE', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Ghana', 'code' => 'GHA', 'abbreviation' => 'GH', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Gibraltar', 'code' => 'GIB', 'abbreviation' => 'GI', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Great Britain (England, Scotland, Wales)', 'code' => 'GBR', 'abbreviation' => 'GB', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Greece', 'code' => 'GRC', 'abbreviation' => 'GR', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Greenland', 'code' => 'GRL', 'abbreviation' => 'GL', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Grenada', 'code' => 'GRD', 'abbreviation' => 'GD', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Guadeloupe', 'code' => 'GLP', 'abbreviation' => 'GP', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Guam', 'code' => 'GUM', 'abbreviation' => 'GU', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Guatemala', 'code' => 'GTM', 'abbreviation' => 'GT', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Guinea', 'code' => 'GIN', 'abbreviation' => 'GN', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Guinea-Bissau', 'code' => 'GNB', 'abbreviation' => 'GW', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Guyana', 'code' => 'GUY', 'abbreviation' => 'GY', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Haiti', 'code' => 'HTI', 'abbreviation' => 'HT', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Heard Island and McDonald Islands', 'code' => 'HMD', 'abbreviation' => 'HM', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Honduras', 'code' => 'HND', 'abbreviation' => 'HN', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Hong Kong SAR of PRC', 'code' => 'HKG', 'abbreviation' => 'HK', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Hungary', 'code' => 'HUN', 'abbreviation' => 'HU', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Iceland', 'code' => 'ISL', 'abbreviation' => 'IS', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'India', 'code' => 'IND', 'abbreviation' => 'IN', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Indonesia', 'code' => 'IDN', 'abbreviation' => 'ID', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Iran', 'code' => 'IRN', 'abbreviation' => 'IR', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Iraq', 'code' => 'IRQ', 'abbreviation' => 'IQ', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Ireland', 'code' => 'IRL', 'abbreviation' => 'IE', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Israel', 'code' => 'ISR', 'abbreviation' => 'IL', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Italy', 'code' => 'ITA', 'abbreviation' => 'IT', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Jamaica', 'code' => 'JAM', 'abbreviation' => 'JM', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Japan', 'code' => 'JPN', 'abbreviation' => 'JP', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Jordan', 'code' => 'JOR', 'abbreviation' => 'JO', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Kazakhstan', 'code' => 'KAZ', 'abbreviation' => 'KZ', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Kenya', 'code' => 'KEN', 'abbreviation' => 'KE', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Kiribati', 'code' => 'KIR', 'abbreviation' => 'KI', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Republic of Korea (South Korea)', 'code' => 'KOR', 'abbreviation' => 'KR', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Korea, Democratic People\'s Republic (North Korea)', 'code' => 'PRK', 'abbreviation' => 'KP', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Kosovo', 'code' => 'UNK', 'abbreviation' => 'XK', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Kuwait', 'code' => 'KWT', 'abbreviation' => 'KW', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Kyrgyzstan', 'code' => 'KGZ', 'abbreviation' => 'KG', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Lao People\'s Democratic Republic', 'code' => 'LAO', 'abbreviation' => 'LA', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Latvia', 'code' => 'LVA', 'abbreviation' => 'LV', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Lebanon', 'code' => 'LBN', 'abbreviation' => 'LB', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Lesotho', 'code' => 'LSO', 'abbreviation' => 'LS', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Liberia', 'code' => 'LBR', 'abbreviation' => 'LR', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Libyan Arab Jamahiriya', 'code' => 'LBY', 'abbreviation' => 'LY', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Liechtenstein', 'code' => 'LIE', 'abbreviation' => 'LI', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Lithuania', 'code' => 'LTU', 'abbreviation' => 'LT', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Luxembourg', 'code' => 'LUX', 'abbreviation' => 'LU', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Macao SAR of PRC (Macau)', 'code' => 'MAC', 'abbreviation' => 'MO', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Macedonia', 'code' => 'MKD', 'abbreviation' => 'MK', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Madagascar', 'code' => 'MDG', 'abbreviation' => 'MG', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Malawi', 'code' => 'MWI', 'abbreviation' => 'MW', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Malaysia', 'code' => 'MYS', 'abbreviation' => 'MY', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Maldives', 'code' => 'MDV', 'abbreviation' => 'MV', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Mali', 'code' => 'MLI', 'abbreviation' => 'ML', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Malta', 'code' => 'MLT', 'abbreviation' => 'MT', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Marshall Islands', 'code' => 'MHL', 'abbreviation' => 'MH', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Martinique', 'code' => 'MTQ', 'abbreviation' => 'MQ', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Mauritania', 'code' => 'MRT', 'abbreviation' => 'MR', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Mauritius', 'code' => 'MUS', 'abbreviation' => 'MU', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Mayotte', 'code' => 'MYT', 'abbreviation' => 'YT', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Mexico', 'code' => 'MEX', 'abbreviation' => 'MX', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Micronesia, Federated States of', 'code' => 'FSM', 'abbreviation' => 'FM', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Monaco', 'code' => 'MCO', 'abbreviation' => 'MC', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Mongolia', 'code' => 'MNG', 'abbreviation' => 'MN', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Montenegro', 'code' => 'MNE', 'abbreviation' => 'ME', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Montserrat', 'code' => 'MSR', 'abbreviation' => 'MS', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Morocco', 'code' => 'MAR', 'abbreviation' => 'MA', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Mozambique', 'code' => 'MOZ', 'abbreviation' => 'MZ', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Myanmar', 'code' => 'MMR', 'abbreviation' => 'MM', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Namibia', 'code' => 'NAM', 'abbreviation' => 'NA', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Nauru', 'code' => 'NRU', 'abbreviation' => 'NR', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Nepal', 'code' => 'NPL', 'abbreviation' => 'NP', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Netherlands', 'code' => 'NLD', 'abbreviation' => 'NL', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Netherlands Antilles', 'code' => 'ANT', 'abbreviation' => 'AN', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'New Caledonia', 'code' => 'NCL', 'abbreviation' => 'NC', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'New Zealand', 'code' => 'NZL', 'abbreviation' => 'NZ', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Nicaragua', 'code' => 'NIC', 'abbreviation' => 'NI', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Niger', 'code' => 'NER', 'abbreviation' => 'NE', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Nigeria', 'code' => 'NGA', 'abbreviation' => 'NG', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Niue', 'code' => 'NIU', 'abbreviation' => 'NU', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Norfolk Island', 'code' => 'NFK', 'abbreviation' => 'NF', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Northern Mariana Islands', 'code' => 'MNP', 'abbreviation' => 'MP', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Norway', 'code' => 'NOR', 'abbreviation' => 'NO', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Oman', 'code' => 'OMN', 'abbreviation' => 'OM', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Pakistan', 'code' => 'PAK', 'abbreviation' => 'PK', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Palau', 'code' => 'PLW', 'abbreviation' => 'PW', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Panama', 'code' => 'PAN', 'abbreviation' => 'PA', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Papua New Guinea', 'code' => 'PNG', 'abbreviation' => 'PG', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Paraguay', 'code' => 'PRY', 'abbreviation' => 'PY', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Peru', 'code' => 'PER', 'abbreviation' => 'PE', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Philippines', 'code' => 'PHL', 'abbreviation' => 'PH', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Pitcairn', 'code' => 'PCN', 'abbreviation' => 'PN', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Poland', 'code' => 'POL', 'abbreviation' => 'PL', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Portugal', 'code' => 'PRT', 'abbreviation' => 'PT', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Puerto Rico', 'code' => 'PRI', 'abbreviation' => 'PR', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Qatar', 'code' => 'QAT', 'abbreviation' => 'QA', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Republic of Moldova', 'code' => 'MDA', 'abbreviation' => 'MD', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Reunion', 'code' => 'REU', 'abbreviation' => 'RE', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Romania', 'code' => 'ROM', 'abbreviation' => 'RO', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Russia', 'code' => 'RUS', 'abbreviation' => 'RU', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Rwanda', 'code' => 'RWA', 'abbreviation' => 'RW', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Saint Helena', 'code' => 'SHN', 'abbreviation' => 'SH', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Saint Kitts and Nevis', 'code' => 'KNA', 'abbreviation' => 'KN', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Saint Lucia', 'code' => 'LCA', 'abbreviation' => 'LC', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Saint Pierre and Miquelon', 'code' => 'SPM', 'abbreviation' => 'PM', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Saint Vincent and the Grenadines', 'code' => 'VCT', 'abbreviation' => 'VC', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Samoa', 'code' => 'WSM', 'abbreviation' => 'WS', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'San Marino', 'code' => 'SMR', 'abbreviation' => 'SM', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Sao Tome and Principe', 'code' => 'STP', 'abbreviation' => 'ST', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Saudi Arabia', 'code' => 'SAU', 'abbreviation' => 'SA', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Senegal', 'code' => 'SEN', 'abbreviation' => 'SN', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Serbia', 'code' => 'SRB', 'abbreviation' => 'RS', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Seychelles', 'code' => 'SYC', 'abbreviation' => 'SC', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Sierra Leone', 'code' => 'SLE', 'abbreviation' => 'SL', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Singapore', 'code' => 'SGP', 'abbreviation' => 'SG', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Slovakia', 'code' => 'SVK', 'abbreviation' => 'SK', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Slovenia', 'code' => 'SVN', 'abbreviation' => 'SI', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Solomon Islands', 'code' => 'SLB', 'abbreviation' => 'SB', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Somalia', 'code' => 'SOM', 'abbreviation' => 'SO', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'South Africa', 'code' => 'ZAF', 'abbreviation' => 'ZA', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'South Georgia and South Sandwich Islands', 'code' => 'SGS', 'abbreviation' => 'GS', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Spain', 'code' => 'ESP', 'abbreviation' => 'ES', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Sri Lanka', 'code' => 'LKA', 'abbreviation' => 'LK', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Sudan', 'code' => 'SDN', 'abbreviation' => 'SD', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Suriname', 'code' => 'SUR', 'abbreviation' => 'SR', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Svalbard and Jan Mayen', 'code' => 'SJM', 'abbreviation' => 'SJ', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Swaziland', 'code' => 'SWZ', 'abbreviation' => 'SZ', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Sweden', 'code' => 'SWE', 'abbreviation' => 'SE', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Switzerland', 'code' => 'CHE', 'abbreviation' => 'CH', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Syria', 'code' => 'SYR', 'abbreviation' => 'SY', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Taiwan', 'code' => 'TWN', 'abbreviation' => 'TW', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Tajikistan', 'code' => 'TJK', 'abbreviation' => 'TJ', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Tanzania, United Republic of', 'code' => 'TZA', 'abbreviation' => 'TZ', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Thailand', 'code' => 'THA', 'abbreviation' => 'TH', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Togo', 'code' => 'TGO', 'abbreviation' => 'TG', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Tokelau', 'code' => 'TKL', 'abbreviation' => 'TK', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Tonga', 'code' => 'TON', 'abbreviation' => 'TO', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Trinidad and Tobago', 'code' => 'TTE', 'abbreviation' => 'TT', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Tunisia', 'code' => 'TUN', 'abbreviation' => 'TN', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Turkey', 'code' => 'TUR', 'abbreviation' => 'TR', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Turkmenistan', 'code' => 'TKM', 'abbreviation' => 'TM', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Turks and Caicos Islands', 'code' => 'TCA', 'abbreviation' => 'TC', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Tuvalu', 'code' => 'TUV', 'abbreviation' => 'TV', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Uganda', 'code' => 'UGA', 'abbreviation' => 'UG', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Ukraine', 'code' => 'UKR', 'abbreviation' => 'UA', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'United Arab Emirates', 'code' => 'ARE', 'abbreviation' => 'AE', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'United States', 'code' => 'USA', 'abbreviation' => 'US', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'United States Minor Outlying Islands', 'code' => 'UMI', 'abbreviation' => 'UM', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Uruguay', 'code' => 'URY', 'abbreviation' => 'UY', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Uzbekistan', 'code' => 'UZB', 'abbreviation' => 'UZ', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Vanuatu', 'code' => 'VUT', 'abbreviation' => 'VU', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Vatican City State', 'code' => 'VAT', 'abbreviation' => 'VA', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Venezuela', 'code' => 'VEN', 'abbreviation' => 'VE', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Vietnam', 'code' => 'VNM', 'abbreviation' => 'VN', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Virgin Islands (UK)', 'code' => 'VGB', 'abbreviation' => 'VG', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Virgin Islands (US)', 'code' => 'VIR', 'abbreviation' => 'VI', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Wallis and Futuna', 'code' => 'WLF', 'abbreviation' => 'WF', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Western Sahara', 'code' => 'ESH', 'abbreviation' => 'EH', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Yemen', 'code' => 'YEM', 'abbreviation' => 'YE', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Zambia', 'code' => 'ZMB', 'abbreviation' => 'ZM', 'created_at' => $now, 'updated_at' => $now],
        ['label' => 'Zimbabwe', 'code' => 'ZWE', 'abbreviation' => 'ZW', 'created_at' => $now, 'updated_at' => $now],
    ];
}

/**
 * Returns an array of Mobile Carriers
 *
 * @return array
 */
function mobileCarrierList()
{
    $now = Carbon\Carbon::now('utc')->toDateTimeString();
    $usa_id = App\Model\Country::where('code', 'USA')->first()->id;
    $can_id = App\Model\Country::where('code', 'CAN')->first()->id;

    return [
        ['country_id' => $usa_id, 'label' => 'AT&T', 'code' => 'att', 'created_at' => $now, 'updated_at' => $now],
        ['country_id' => $usa_id, 'label' => 'Air Fire Mobile', 'code' => 'airfiremobile', 'created_at' => $now, 'updated_at' => $now],
        ['country_id' => $usa_id, 'label' => 'Alaska Communicates', 'code' => 'alaskacommunicates', 'created_at' => $now, 'updated_at' => $now],
        ['country_id' => $usa_id, 'label' => 'Ameritech', 'code' => 'ameritech', 'created_at' => $now, 'updated_at' => $now],
        ['country_id' => $usa_id, 'label' => 'Boost Mobile', 'code' => 'moostmobile', 'created_at' => $now, 'updated_at' => $now],
        ['country_id' => $usa_id, 'label' => 'Clear Talk', 'code' => 'cleartalk', 'created_at' => $now, 'updated_at' => $now],
        ['country_id' => $usa_id, 'label' => 'Cricket', 'code' => 'cricket', 'created_at' => $now, 'updated_at' => $now],
        ['country_id' => $usa_id, 'label' => 'Metro PCS', 'code' => 'metropcs', 'created_at' => $now, 'updated_at' => $now],
        ['country_id' => $usa_id, 'label' => 'NexTech', 'code' => 'nextech', 'created_at' => $now, 'updated_at' => $now],
        ['country_id' => $usa_id, 'label' => 'Project Fi', 'code' => 'projectfi', 'created_at' => $now, 'updated_at' => $now],
        ['country_id' => $can_id, 'label' => 'Rogers Wireless', 'code' => 'rogerswireless', 'created_at' => $now, 'updated_at' => $now],
        ['country_id' => $usa_id, 'label' => 'Unicel', 'code' => 'unicel', 'created_at' => $now, 'updated_at' => $now],
        ['country_id' => $usa_id, 'label' => 'Verizon Wireless', 'code' => 'verizonwireless', 'created_at' => $now, 'updated_at' => $now],
        ['country_id' => $usa_id, 'label' => 'Virgin Mobile', 'code' => 'virginmobile', 'created_at' => $now, 'updated_at' => $now],
        ['country_id' => $usa_id, 'label' => 'Sprint', 'code' => 'sprint', 'created_at' => $now, 'updated_at' => $now],
        ['country_id' => $usa_id, 'label' => 'T-Mobile', 'code' => 'tmobile', 'created_at' => $now, 'updated_at' => $now],
    ];
}

/**
 * Generates random bytes and base 64 encodes them
 *
 * @param int $length
 * @return string
 */
function generate_random_encoded_bytes($length = 32)
{
    if (version_compare(PHP_VERSION, '7.0.0') >= 0) {
        // We are on php 7 or higher so we can use new more secure function
        return base64_encode(random_bytes($length));
    } else {
        // We are not on php 7 and have to fall back on openssl_random_pseudo_bytes
        return base64_encode(openssl_random_pseudo_bytes($length));
    }
}


/**
 * Generates an IV for encryption
 *
 * @return string
 */
function generate_iv()
{
    return generate_random_encoded_bytes(openssl_cipher_iv_length('aes-256-cbc'));
}

/**
 * Encrypts broadcast data string
 *
 * Returns a string with the IV appended to encrypted data deliminated by a colon
 *
 * @param $data
 * @param null $key
 * @param null $iv
 * @return string
 */
function encrypt_broadcast_data($data, $key = null, $iv = null)
{
    $key = (empty($key)) ? base64_decode(env('BC_KEY')) : base64_decode($key);
    $iv = (empty($iv)) ? base64_decode(generate_iv()) : base64_decode($iv);

    if (empty($key))
        throw new \Illuminate\Contracts\Encryption\EncryptException('No BC_KEY defined. Please generate a BC_KEY and ensure it is in your .env file. Hint: `php artisan orm:bckey`');

    $encrypted_data = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return $encrypted_data . ':' . base64_encode($iv);
}

/**
 * @param string $path
 * @return mixed|string
 */
function fixPath($path = '')
{
    $path = str_replace('\\', '/', trim($path));
    return (substr($path, -1) != '/') ? $path .= '/' : $path;
}
