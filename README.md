# waiter
第三方支付接口组件

使用示例：
require_once('vendor/autoload.php');

use Waiter\Waiter;
$config = [
    'app_id'     => '你的appid',
    'mch_id'     => '你的mch_id',
    'pay_key'    => '你的pay_key',
    'app_secret' => '你的app_secret',
    'mode'       => 'normal'
];
$parameter = [
    'body'          => '微信小程序支付',
    'attach'        => 'xxxxx,
    'out_trade_no'  => 1234231423452,
    'total_fee'     => 1,
    'openid'        => '用户的openid',
    'notify_url'    => '你的回调地址',
];


//微信小程序支付
//$result = Waiter::Wechat($config)->Payment()->Mini()->pay($parameter);
//var_dump($result);exit;
//微信小程序获取token
//$result = Waiter::Wechat($config)->Login()->Mini()->getToken('081Zvk000XEGdL1NOb300ODYff1Zvk0G');
//var_dump($result);exit;

$config = [
    'app_id'        => '你的支付宝appid',
    'private_key'   => '你的支付宝私钥',
    'public_key'    => '你的支付宝公钥',
    'mode'          => 'normal',
    'notify_url'    => '你的回调地址',
];
$parameter = [
    'body'          => '支付宝小程序订单支付',
    'subject'       => '订单支付',
    'attach'        => 'xxxx',
    'out_trade_no'  => 1234231423452,
    'total_amount'  => 0.01,
    'buyer_id'      => 2088302191714811,
];
//支付宝回调验证
//$result = Waiter::Alipay($config)->Payment()->Support()->verify(['sign'=>'xzasdcasdc']);
//var_dump($result);exit;
//支付宝小程序支付
//$result = Waiter::Alipay($config)->Payment()->Mini()->pay($parameter);
//print_r($result);exit;
//支付宝小程序获取token
$result = Waiter::Alipay($config)->Login()->Mini()->getToken('f5326b49b82c4913bbe3978d6bc7WX81');
var_dump($result);exit;
