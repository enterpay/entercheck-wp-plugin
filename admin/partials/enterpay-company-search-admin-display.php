<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://demoshop.entercheck.eu/
 * @since      1.0.0
 *
 * @package    Enterpay_Company_Search
 * @subpackage Enterpay_Company_Search/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->


<form action="options.php" method="post">
    <?php 
    settings_fields( 'dbi_example_plugin_options' );
    do_settings_sections( 'dbi_example_plugin' ); ?>
    <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Grant Access' ); ?>" />

    <?php
    function dbi_plugin_section_text() {
        echo '<p>Here you can set all the options for using the API</p>';
    }

    function dbi_plugin_setting_username() {
        $options = get_option( 'dbi_example_plugin_options' );
        echo "<input id='dbi_plugin_setting_username' name='dbi_example_plugin_options[username]' type='text' value='" . esc_attr( $options['username'] ) . "' />";
    }

    function dbi_plugin_setting_password() {
        $options = get_option( 'dbi_example_plugin_options' );
        echo "<input id='dbi_plugin_setting_password' name='dbi_example_plugin_options[password]' type='text' value='" . esc_attr( $options['password'] ) . "' />";
    }

    function dbi_plugin_setting_start_date() {
        $options = get_option( 'dbi_example_plugin_options' );
        echo "<input id='dbi_plugin_setting_start_date' name='dbi_example_plugin_options[start_date]' type='text' value='" . esc_attr( $options['start_date'] ) . "' />";
    }

    function dbi_plugin_setting_enterpaytoken(){

    }
    ?>
</form>

<?php 

$curl = curl_init();
$options = get_option( 'dbi_example_plugin_options' );

$data = array(
    "username" => $options['username'],
    "password" => $options['password']
);
$data = json_encode($data);
$options =array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://api.test.entercheck.eu/v1/auth',
    CURLOPT_POST => true,
    CURLOPT_USERAGENT => "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)",
    CURLOPT_POSTFIELDS => $data
 );

curl_setopt_array($curl, $options);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data))
);

$resp = curl_exec($curl);

//Kết quả trả tìm kiếm trả về dạng JSON
if($resp){
    $token = json_decode($resp)->token;
    if($token){

        update_option('enterpay_token',$token);
        //update_option('enterpay_token',"eyJraWQiOiJoS1pSVERObkRJTDVvMGU3aENVb0ZLdGhzZGk4dXlUSWtGcDR6clJTUDQwPSIsImFsZyI6IlJTMjU2In0.eyJzdWIiOiI2NTdiYzUxYi0xNTNiLTQ1NWMtOWQ0OC0zNTZiOTc5N2JjODAiLCJjb2duaXRvOmdyb3VwcyI6WyJhZG1pbiJdLCJlbWFpbF92ZXJpZmllZCI6dHJ1ZSwiaXNzIjoiaHR0cHM6XC9cL2NvZ25pdG8taWRwLmV1LWNlbnRyYWwtMS5hbWF6b25hd3MuY29tXC9ldS1jZW50cmFsLTFfM0JPRDRDb1B3IiwicGhvbmVfbnVtYmVyX3ZlcmlmaWVkIjpmYWxzZSwiY29nbml0bzp1c2VybmFtZSI6Indvb2NvbW1lcmNlX2RlbW8iLCJhdWQiOiI2M3QwN3RwNzFhbXJuZWN2djB0dXU3bmZhciIsImV2ZW50X2lkIjoiYjRlOTlmM2EtMzQ1NS00YTc3LTkyZjctZmRlYmQxNmIwOTlkIiwidG9rZW5fdXNlIjoiaWQiLCJjdXN0b206b3JnIjoiOGIzZDA0M2YtNTk0OS00M2QyLTkxOGEtNjFmMDJiODM4ZTMxIiwiYXV0aF90aW1lIjoxNjgxNDYyNTY3LCJleHAiOjE2ODE0NjYxNjcsImlhdCI6MTY4MTQ2MjU2NywiZW1haWwiOiJ0ZWNobmljYWxAZW50ZXJwYXkuZmkifQ.sQW8tOYAI1H017Abu6zwsUozyKXI8noO6URJIuVDoxpLWmQo-pSc0n4e7kNfZd8lzcInETO72dsLkGIs5YKJl-Qk-G717Aoz8nB5CN4HgVGD04Ac5Gt3g7gcxEKYhd28OAZt6T5YaL_BYqhLFzVMIMH95vJ3qDI2jJpXBkG6O89IRCplGTGThdQYUCum-j_OgeOHpMLULH7h6bC8PULS3G2QgJaM-AZXEvp-S1KHBgyfiShJuhlfAM13dHkIlFf7W7TJOnGVFuxbqmASPW0Tfkn7sDPtZulEueZPQA0ZypfNGtzOJ3J_wo5wk1aQxw5IdQNrLPwcUZ0xV36VjLP333");
        ?>
        <p style="border:1px solid gray;padding:10px;margin-top:30px;width:100%;overflow: scroll;max-width: 90%;"><b>Token: </b><?=$token?></p>
        <br>
        <button id="test-call-btn" onclick="test()">Make a test API call</button>
        <script type="text/javascript">
            nonce = "<?=wp_create_nonce("my_user_vote_nonce")?>"
        </script>
        <div id="test_result"></div>
        <?php

        
    } else {
        ?><p><b><i>API credentials are incorrect!</i></b></p><?php
    }   


}


curl_close($curl);



?>

