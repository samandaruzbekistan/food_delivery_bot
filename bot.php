<?php 
require_once "Telegram.php";
include 'db.php';
$token = "";

// Created at Samandar Sariboyev - samandarsariboyev69@gmail.com - +998 97 567 20 09

$telegram = new Telegram($token);
$data = $telegram->getData();
$message = $data['message'];
$message_id = $message['message_id'];
$text = $message['text'];
$chat_id = $message['chat']['id'];
$db = new DB($chat_id, $con);
$callback_query = $telegram->Callback_Query();
$chatID = $telegram->Callback_ChatID();
$latitude = $message['location']['latitude'];
$longitude = $message['location']['longitude'];;
$adminlar = [499270876,848511386];


if ($callback_query != null && $callback_query != '') {
    $callback_data = $telegram->Callback_Data();
    $r = "Select * from `users` where `chat_id` = {$chatID}";
    $res = mysqli_query($con, $r);
    $p = mysqli_fetch_assoc($res);
    $page = $p['page'];
    if (in_array($chatID, $adminlar)) {
        switch ($page) {
            case 'aorders':
                $sqqq = "UPDATE `users` SET `order_id`='{$callback_data}' WHERE chat_id = {$chatID}";
                mysqli_query($con, $sqqq);
                $sql = "select * from `orders` where id = {$callback_data}";
                $r = mysqli_fetch_assoc(mysqli_query($con, $sql));
                $sq = "select order_profuct.count, order_profuct.price, product.name from order_profuct INNER JOIN product ON product.id = order_profuct.product_id where order_profuct.chat_id = {$r['chat_id']}";
                $rd = mysqli_query($con, $sq);
                $string = "<b>Buyurtma:\n\n";
                while ($row = mysqli_fetch_assoc($rd)) {
                    $price = number_format($row['price'],0,","," ");
                    $string = $string."{$row['name']} - {$row['count']} ta - {$price} so'm\n";
                }
                $price = number_format($r['summa'],0,","," ");
                $string = $string."\n\nTelefon: {$r['phone']}\nManzil: {$r['address']}\nUmumiy summa: {$price}\n\n";
                if ($r['status'] == "1") {
                    $string = $string."Xolati: ❕ Yetkazib berilmagan</b>";
                    $b = ['✅ Yetkazildi', "↪️ Orqaga"];
                }
                elseif ($r['status'] == "0") {
                    $string = $string."Xolati: ❔ Tasdiqlanmagan</b>";
                    $b = ['✅ Tasdiqlash', "❌ Bekor qilish"];
                }
                sendTextWithKeyboardCall($b, $string);
                SetPageCall('orderconfirm', $chatID);
                break;
            case '✅ Tasdiqlash':
                
                break;
            default:
                break;
        }
    }
    else {
        switch ($page) {
            case 'basketviewedit':
                $db->editbasketproduct($callback_data);
                break;
            
            default:
                # code...
                break;
        }
    }
    
}
elseif (in_array($chat_id, $adminlar)) {
    if ($text == '/start') {
        AStart();
    }
    else {
        $r = mysqli_query($con, "Select * from `users` where `chat_id` = {$chat_id}");
        $p = mysqli_fetch_assoc($r);
        $page = $p['page'];
        switch ($page) {
            case 'start':
                switch ($text) {
                    case 'Maxsulotlar':
                        AMenu();
                        break;
                    case 'Buyurtmalar':
                        $db->Orders();
                        break;
                    case 'Statistika':
                        $db->statistika();
                        break;
                    case 'Xabar jo\'natish':
                        $db->sendMessageUsers();
                        break;
                    default:
                        # code...
                        break;
                }
                break;
            case 'statistika':
                switch ($text) {
                    case '📆 Sana bo\'yicha':
                        $db->statbydateRequest();
                        break;
                    case '🗓 Ushbu kun':
                        $db->stattoday();
                        break;
                    case '📊 Ushbu oy':
                        $db->statmonth();
                        break;
                    case '↪️ Orqaga':
                        AStart();
                        break;
                    default:
                        # code...
                        break;
                }
                break;
            case 'sendingdate':
                switch ($text) {
                    case '↪️ Orqaga':
                        $db->statistika();
                        break;
                    
                    default:
                        $db->statbaydate($text);
                        break;
                }
                break;
            case 'statbydateok':
                if($text == "↪️ Orqaga"){
                    $db->statistika();
                }
                break;
            case 'amenu':
                switch ($text) {
                    case '↪️ Orqaga':
                        AStart();
                        break;
                    case '🇺🇿 Milliy':
                        $db->GetAllProducts('1');
                        break;
                    case '🇹🇷 Turk':
                        $db->GetAllProducts('2');
                        break;
                    case '🇪🇺 Evropa':
                        $db->GetAllProducts('3');
                        break;
                    case '🧃 Salqin ichimliklar':
                        $db->GetAllProducts('4');
                        break;
                    case '🍾 Spirtli ichimliklar':
                        $db->GetAllProducts('5');
                        break;
                    case '🥗 Salatlar':
                        $db->GetAllProducts('6');
                        break;
                    case '🥩 Asartilar':
                        $db->GetAllProducts('7');
                        break;
                    case '🍡 Shashliklar':
                        $db->GetAllProducts('8');
                        break;
                    case '🥯 Non maxsulotlari':
                        $db->GetAllProducts('9');
                        break;
                    case '🍕 Pitsalar':
                        $db->GetAllProducts('10');
                        break;
                    default:
                        # code...
                        break;
                }
                break;
            case 'xabaryuborish':
                if ($text == '❌ Bekor qilish') {
                    AStart();
                }
                else {
                    $db->sendMessageUsersText($text);
                }
                break;
            case 'getproducts':
                switch ($text) {
                    case '➕ Maxsulot qo\'shish':
                        $db->AddProductName();
                        break;
                    case '↪️ Orqaga':
                        AMenu();
                        break;
                    default:
                        $db->ViewProduct($text);
                        break;
                }
                break;
            case 'setname':
                switch ($text) {
                    case '❌ Bekor qilish':
                        $db->CancelAdd();
                        break;
                    default:
                        $db->SetNameDb($text);
                        break;
                }
                break;
            case 'setprice':
                switch ($text) {
                    case '❌ Bekor qilish':
                        $db->CancelAdd();
                        break;
                    default:
                        $db->SetPriceDb($text);
                        break;
                }
                break;
            case 'setphoto':
                switch ($text) {
                    case '❌ Bekor qilish':
                        $db->CancelAdd();
                        break;
                    default:
                        $db->SetPhotoDb($message['photo'][0]['file_id']);
                        break;
                }
                break;
            case 'editproduct':
                switch ($text) {
                    case '✏️ Nomini o\'zgartirish':
                        $db->EditName();
                        break;
                    case '💸 Narxini o\'zgartirish':
                        $db->EditPrice();
                        break;
                    case '🖼 Rasmini o\'zgartirish':
                        $db->EditPhoto();
                        break;
                    case '↪️ Orqaga':
                        AMenu();
                        break;
                    case '🗑 O\'chirish':
                        $db->DeleteProduct();
                        break;
                    default:
                        # code
                        break;
                }
                break;
            case 'sendingname':
                switch ($text) {
                    case '❌ Bekor qilish':
                        AMenu();
                        break;
                    
                    default:
                        $db->updName($text);
                        break;
                }
                break;
            case 'sendingprice':
                switch ($text) {
                    case '❌ Bekor qilish':
                        AMenu();
                        break;
                    
                    default:
                        $db->updPrice($text);
                        break;
                }
                break;
            case 'sendingphoto':
                switch ($text) {
                    case '❌ Bekor qilish':
                        AMenu();
                        break;
                    
                    default:
                        $db->updPhoto($message['photo'][0]['file_id']);
                        break;
                }
                break;
            case 'orderconfirm':
                switch ($text) {
                    case '✅ Tasdiqlash':
                        $row = mysqli_fetch_assoc(mysqli_query($con, "select order_id from `users` where chat_id = {$chat_id}"));
                        mysqli_query($con, "UPDATE `orders` SET `status`='1' WHERE id = {$row['order_id']}");
                        $rw = mysqli_fetch_assoc(mysqli_query($con, "select chat_id from `orders` where id = {$row['order_id']}"));
                        $content = ['chat_id' => $rw['chat_id'], "text" => "Buyurtmangiz tasdiqlandi ✅\n\nTez orada yetkaziladi\n\nSizga xizmat ko'rsatishimizdan mamnunmiz😊", 'parse_mode' => "HTML"];
                        $telegram->sendMessage($content);
                        $db->AdminViewOrder($row['order_id']);
                        break;
                    case '✅ Yetkazildi':
                        $db->delivered();
                        break;
                    case '↪️ Orqaga':
                        AStart();
                        break;
                    case '❌ Bekor qilish':
                        $db->ordercansel();
                        break;
                    default:
                        # code...
                        break;
                }
                break;
            case 'adminvieworder':
                switch ($text) {
                    case '✅ Yetkazildi':
                        $db->delivered();
                        break;
                    case '↪️ Orqaga':
                        AStart();
                        break;
                    case '❌ Bekor qilish':
                        $db->ordercansel();
                        break;
                    case '✅ Tasdiqlash':
                        $row = mysqli_fetch_assoc(mysqli_query($con, "select order_id from `users` where chat_id = {$chat_id}"));
                        mysqli_query($con, "UPDATE `orders` SET `status`='1' WHERE id = {$row['order_id']}");
                        $rw = mysqli_fetch_assoc(mysqli_query($con, "select chat_id from `orders` where id = {$row['order_id']}"));
                        $content = ['chat_id' => $rw['chat_id'], "text" => "Buyurtmangiz tasdiqlandi ✅\n\nTez orada yetkaziladi\n\nSizga xizmat ko'rsatishimizdan mamnunmiz😊", 'parse_mode' => "HTML"];
                        $telegram->sendMessage($content);
                        $db->AdminViewOrder($row['order_id']);
                        break;
                    default:
                        # code...
                        break;
                }
                break;
            default:
                # code...
                break;
    }
    }
    
}
elseif ($text == '/start') {
	Start();
    SetPage('start');
}
else{
    $r = mysqli_query($con, "Select * from `users` where `chat_id` = {$chat_id}");
    $p = mysqli_fetch_assoc($r);
    $page = $p['page'];
    switch ($page) {
        case 'start':
            switch ($text) {
                case '🍽 Menu':
                    Menu();
                    break;  
                case '🛒 Savat':
                    $db->basket();
                    break;  
                case '✅ Buyurtmalarim':
                    $db->myOrders();
                    break;
                case '🔹 Biz haqimizda':
                    $tex = "<b>👋 Assalomu Alaykum Hurmatli {$message['from']['first_name']}</b>\n\nBizning telegram tarmogʻidagi botimizdan foydalanishingizdan xursandmiz 😊\n\nBiz siz uchun mazzali taomlarimizni tezkor va yuqori sifatda yetkazib  beramiz⚡️\n\nBundan tashqari siz Guliston shahrimizdagi restoranimizga tashrif buyurib mazzali taomlarimizdan baxramand bo'lishimgiz mumkin😉\n\nBIZNI TANLAB ADASHMADINGIZ😊\n\nBizning Manzil ⤵️⤵️\n\nhttps://maps.app.goo.gl/cMjiJXeNh6HxbCSY9";
                    $telegram->sendPhoto(['chat_id' => $chat_id, 'photo' => "AgACAgIAAxkBAAIT0WMCINEYLMHfrhOuVMJNFtuR-VVwAAKIxTEb8dMRSHNYv47LeWm-AQADAgADcwADKQQ", 'caption' => $tex, 'parse_mode' => 'html']);
                    break;    
                case '📞 Bog\'lanish':
                    sendMessage("<b>Biz bilan bog'lanish uchun raqamlar:\n\n📞 +998 97 567 20 09 \n\nDostavka uchun: @yagonares_bot</b>");
                    break;
                default:
                    Start();    
                    break;
            }
        case 'menu':
            switch ($text) {
                case '🍲 Taomlar':
                    Taomlar();
                    break;
                case '↪️ Orqaga':
                    Start();
                    break;
                case '☕️ Ichimliklar':
                    Ichimliklar();
                    break;
                case '🍖 Asarti va shashliklar':
                    Asarti();
                    break;
                case '🥗 Salatlar':
                    $db->getProductClinet(6);
                    break;
                case '🥯 Non maxsulotlari':
                    $db->getProductClinet(9);
                    break;
                case '🍕 Pitsa va Pide':
                    $db->getProductClinet(10);
                    break;
                default:
                // sendMessage('⬇️ Quidagilardan birni tanlang');
                    break;
            }
            break;
        case 'taomlar':
            switch ($text) {
                case '↪️ Orqaga':
                    Menu();
                    break;
                case '🇺🇿 Milliy':
                    $db->getProductClinet(1);
                    break;
                case '🇹🇷 Turk':
                    $db->getProductClinet(2);
                    break;
                case '🇪🇺 Evropa':
                    $db->getProductClinet(3);
                    break;
                default:
                sendMessage('⬇️ Quidagilardan birni tanlang');
                    break;
            }
            break;
        case 'ichimliklar':
            switch ($text) {
                case '↪️ Orqaga':
                    Menu();
                    break;
                case '🍾 Spirtli ichimliklar':
                    $db->getProductClinet(5);
                    break;
                case '🧃 Salqin ichimliklar':
                    $db->getProductClinet(4);
                    break;
                default:
                sendMessage('⬇️ Quidagilardan birni tanlang');
                    break;
            }
            break;
        case 'asartilar':
            switch ($text) {
                case '↪️ Orqaga':
                    Menu();
                    break;
                case '🥩 Asartilar':
                    $db->getProductClinet(7);
                    break;
                case '🍡 Shashliklar':
                    $db->getProductClinet(8);
                    break;
                default:
                    sendMessage('⬇️ Quidagilardan birni tanlang');
                    break;
            }
            break;
        case 'select':
            switch ($text) {
                case '↪️ Orqaga':
                    Menu();
                    break;
                
                default:
                    $sql = "select * from product where name = '{$text}'";
                    $r = mysqli_query($con, $sql);
                    if(mysqli_num_rows($r) < 1){
                        sendMessage('Taom yozilgan tugmani bosing');
                    }
                    else{
                        $row = mysqli_fetch_assoc($r);
                        $sq = "UPDATE `users` SET `product_id`={$row['id']} WHERE chat_id = {$chat_id}";
                        $t = mysqli_query($con, $sq);
                        SetPage('sendingcount');
                        $narx = number_format($row['price'],0,","," ");
                        $options = [[$telegram->buildKeyboardButton('❌ Bekor qilish')]];
                        $keyb = $telegram->buildKeyBoard($options,$onetime = false, $resize = true);
                        $string = "<b>🍲 Nomi: {$row['name']}\n💰 Narxi: {$narx}\n\nUshbu maxsulotdan qancha miqdorda buyurtma qilasiz? Miqdorni yuboring ⬇️\n\n</b>"."❕ Eslatma: Faqat raqam yuboring(0.5, 1, 1.5, 2)";
                        $telegram->sendPhoto(['chat_id' => $chat_id, 'reply_markup' => $keyb, 'photo' => $row['img'], 'caption' => $string, 'parse_mode' => 'html']);
                    }
                    break;
            }
            break;
        case 'sendingcount':
            switch ($text) {
                case '❌ Bekor qilish':
                    Menu();
                    break;
                
                default:
                    $res = preg_replace("/[^0-9.,]/", "", $text );
                    $sql = "select product_id from users where chat_id = {$chat_id}";
                    $r = mysqli_query($con, $sql);
                    $row = mysqli_fetch_assoc($r);
                    $sql2 = "INSERT INTO basket ( chat_id, product_id, count, price )
                    SELECT  {$chat_id}, product.id, {$res}, product.price * {$res}
                    FROM    product
                    WHERE   product.id = {$row['product_id']}";
                    $r = mysqli_query($con, $sql2);
                    $sql3 = "SELECT product.id, product.name,product.price,product.img FROM product INNER JOIN users ON users.product_id = product.id WHERE users.chat_id = {$chat_id};";
                    $r = mysqli_query($con, $sql3);
                    $row = mysqli_fetch_assoc($r);
                    $summa = $row['price'] * $res;
                    $summa = number_format($summa,0,","," ");
                    $narx = number_format($row['price'],0,","," ");
                    $string = "<b>🍲 Nomi: {$row['name']}\n💰 1 maxsulot narxi: {$narx}\n🧩 Miqdori: {$res}\n💸 Umumiy summa: {$summa}\n\n</b><i>Savatga qo'shasizmi?\nTugmalardan birini bosing⬇️</i>";
                    $options = [[$telegram->buildKeyboardButton('❌ Bekor qilish'),$telegram->buildKeyboardButton('🛒 Savatga qo\'shish')]];
                    $keyb = $telegram->buildKeyBoard($options,$onetime = false, $resize = true);
                    $telegram->sendPhoto(['chat_id' => $chat_id, 'reply_markup' => $keyb, 'photo' => $row['img'], 'caption' => $string, 'parse_mode' => 'html']);
                    SetPage('basket');
                    break;
            }
            break;
        case 'basket':
            switch ($text) {
                case '❌ Bekor qilish':
                    $sql = "select product_id from users where chat_id = {$chat_id}";
                    $row = mysqli_fetch_assoc(mysqli_query($con, $sql));
                    $sql2 = "DELETE FROM `basket` WHERE product_id = {$row['product_id']}";
                    $r = mysqli_query($con, $sql2);
                    Menu();
                    break;
                case '🛒 Savatga qo\'shish':
                    sendMessage('🆗 Maxsulot savatga qo\'shildi');
                    Start();
                    break;
                default:
                    sendMessage('⬇️ Quidagilardan birni tanlang');
                    break;
            }
            break;
        case 'basketview':
            switch ($text) {
                case '↪️ Orqaga':
                    Start();
                    break;
                case '🖋 Taxrirlash':
                    $db->basketEdit();
                    break;
                case '✅ Buyurtma qilish':
                    $row = mysqli_query($con, "SELECT * FROM `orders` WHERE chat_id = {$chat_id}");
                    if (mysqli_num_rows($row) > 0) {
                        sendMessage("Sizda buyurma allaqachon mavjud. Buyurtmani yetkazilishini kuting...");
                        Start();
                    }
                    else{
                        $b = [array($telegram->buildKeyboardButton('📍 Joylashuvni yuborish', false, true), $telegram->buildKeyboardButton('❌ Bekor qilish'))];
                        $keyboard = $telegram->buildKeyBoard($b, $onetime = false, $resize = true);
                        $content = array('chat_id' => $chat_id, 'reply_markup' => $keyboard, 'text' => "Joylashuvingizni yuboring");
                        SetPage('getlocation');
                        $telegram->sendMessage($content);
                    }
                    break;
                default:
                    # code...
                    break;
            }
            break;
        case 'editbasketproduct':
            switch ($text) {
                case '🖋 Miqdorini o\'zgartish':
                    $db->EditCountUser();
                    break;
                case '↪️ Orqaga':
                    $db->basket();
                    break;
                case '❌ Savatdan olib tashlash':
                    $sq = "select product_id from users where chat_id = {$chat_id}";
                    $row = mysqli_fetch_assoc(mysqli_query($con,$sq));
                    $sql = "DELETE FROM `basket` WHERE chat_id = {$chat_id} and product_id = {$row['product_id']}";
                    mysqli_query($con, $sql);
                    $db->basket();
                    break;
                default:
                    # code...
                    break;
            }
            break;
        case 'sendeditcount':
            switch ($text) {
                case '↪️ Orqaga':
                    $db->basket();
                    break;
                
                default:
                    $res = preg_replace("/[^0-9.,]/", "", $text );
                    $sq = "select product_id from users where chat_id = {$chat_id}";
                    $row = mysqli_fetch_assoc(mysqli_query($con,$sq));
                    $sql = "select price from product where id = {$row['product_id']}";
                    $r = mysqli_fetch_assoc(mysqli_query($con,$sql)); 
                    $p = $r['price'] * $res;
                    $sql = "UPDATE `basket` SET `count`={$res}, `price` = {$p} WHERE product_id = {$row['product_id']} and chat_id = {$chat_id}";
                    mysqli_query($con, $sql);
                    $db->basket();
                    break;
            }
            break;
        case 'basketviewedit':
            switch ($text) {
                case '↪️ Orqaga':
                    $db->basket();
                    break;
                
                default:
                    # code...
                    break;
            }
            break;
        case 'getlocation':
            if ((isset($text)) and ($text == "❌ Bekor qilish")) {
                Start();
            }
            else{
                $db->saveLocation();
            }
            break;
        case 'sendaddress':
            switch ($text) {
                case '❌ Bekor qilish':
                    Start();
                    break;
                
                default:
                    $db->saveaddress($text);
                    break;
            }
            break;
        case 'savenumber':
            if ($text == "❌ Bekor qilish") {
                Start();
            }
            else {
                mysqli_query($con, "UPDATE `orders` SET `phone`='{$text}' WHERE chat_id = {$chat_id}");
                sendMessage("✅ Buyurtmangiz muvaffaqiyatli qabul qilindi. Tez orada adminlarimiz siz bilan bog'lanishadi va buyurtmangiz yetkaziladi");
                $sql = "INSERT INTO order_profuct ( chat_id, product_id, count, price )
                SELECT  basket.chat_id, basket.product_id, basket.count, basket.price
                FROM    basket WHERE chat_id = {$chat_id}";
                mysqli_query($con, $sql);
                mysqli_query($con, "DELETE FROM `basket` WHERE chat_id = {$chat_id}");
                $row = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(price) FROM `order_profuct` WHERE chat_id = {$chat_id}"));
                mysqli_query($con, "UPDATE `orders` SET `summa`='{$row['SUM(price)']}', `status` = '0' WHERE chat_id = {$chat_id}");
                Start();
                foreach ($adminlar as $i) {
                    $content = ['chat_id' => $i, "text" => "Yangi buyurtma qabul qilindi. Buyurtmalar bo'limini tekshiring", 'parse_mode' => "HTML"];
                    $telegram->sendMessage($content);
                }
            }
            break;
        case 'myOrders':
            if ($text = "↪️ Orqaga") {
                Start();
            }
            break;
        default:
            # code...
            break;
    }
}




// Funksiyalar


function Start(){
	global $chat_id, $message,$con, $data;
    SetPage('start');
    $user = mysqli_query($con, "SELECT * FROM  `users` where `chat_id` =  {$chat_id}");
    $dat = json_encode($data);
    if(mysqli_num_rows($user)<1){
        $sql = "INSERT INTO `users`(`chat_id`, `name`, `page`, `data`) VALUES ($chat_id, '{$message['from']['first_name']}','start', '{$dat}')";
	    $r = mysqli_query($con,$sql);
    }
	$b = ['🍽 Menu', '🛒 Savat', "✅ Buyurtmalarim",'🔹 Biz haqimizda',"📞 Bog'lanish"];
	sendTextWithKeyboard($b, "⬇️ Kerakli bo'limni tanglang:");
}

function Menu()
{
    SetPage('menu');
    $b = ['🍲 Taomlar', '☕️ Ichimliklar', '🥗 Salatlar', '🍖 Asarti va shashliklar', '🥯 Non maxsulotlari',"🍕 Pitsa va Pide", '↪️ Orqaga'];
    sendTextWithKeyboard($b, "Menu:");
}


// Taomlar
function Taomlar()
{
    SetPage('taomlar');
    $b = ['🇺🇿 Milliy', '🇹🇷 Turk', '🇪🇺 Evropa', '↪️ Orqaga'];
    sendTextWithKeyboard($b, "Kerakli bo'limni tanlang:");
}







// Ichimliklar
function Ichimliklar()
{
    SetPage('ichimliklar');
    $b = ['🧃 Salqin ichimliklar', '🍾 Spirtli ichimliklar', '↪️ Orqaga'];
    sendTextWithKeyboard($b, "Bo'limlar:");
}


// Asarti
function Asarti()
{
    SetPage('asartilar');
    $b = ['🥩 Asartilar', '🍡 Shashliklar', '↪️ Orqaga'];
    sendTextWithKeyboard($b, "Bo'limlar:");
}

















// Admin
function AStart()
{
    SetPage('start');
    $b = ['Maxsulotlar', 'Buyurtmalar', 'Statistika', "Xabar jo'natish"];
    sendTextWithKeyboard($b, "Bo'limni tanlang:");
}



function AMenu()
{
    $b = ['🇺🇿 Milliy', '🇹🇷 Turk','🇪🇺 Evropa','🧃 Salqin ichimliklar','🍾 Spirtli ichimliklar','🥗 Salatlar','🥩 Asartilar','🍡 Shashliklar','🥯 Non maxsulotlari','🍕 Pitsalar','↪️ Orqaga'];
    SetPage('amenu');
    sendTextWithKeyboard($b,"Bo'limni tanlang:");
}













function SetPage($name)
{
    global $chat_id, $con;
    $r = mysqli_query($con, "UPDATE `users` SET `page`='{$name}' WHERE `chat_id` = {$chat_id}");
}

function SetPageCall($name, $chatID)
{
    global $con;
    $r = mysqli_query($con, "UPDATE `users` SET `page`='{$name}' WHERE `chat_id` = {$chatID}");
}


function sendMessage($text)
{
    global $telegram, $chat_id;
    $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $text, 'parse_mode' => "HTML"]);
}

function sendMessageCall($text)
{
    global $telegram, $chatID;
    $telegram->sendMessage(['chat_id' => $chatID, 'text' => $text, 'parse_mode' => "HTML"]);
}


function sendTextWithKeyboard($buttons, $text, $backBtn = false)
{
    global $telegram, $chat_id, $texts;
    $option = [];
    if (count($buttons) % 2 == 0) {
        for ($i = 0; $i < count($buttons); $i += 2) {
            $option[] = array($telegram->buildKeyboardButton($buttons[$i]), $telegram->buildKeyboardButton($buttons[$i + 1]));
        }
    } else {
        for ($i = 0; $i < count($buttons) - 1; $i += 2) {
            $option[] = array($telegram->buildKeyboardButton($buttons[$i]), $telegram->buildKeyboardButton($buttons[$i + 1]));
        }
        $option[] = array($telegram->buildKeyboardButton(end($buttons)));
    }
    if ($backBtn) {
        $option[] = [$telegram->buildKeyboardButton($texts->getText("back_btn"))];
    }
    $keyboard = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyboard, 'text' => $text, 'parse_mode' => "HTML");
    $telegram->sendMessage($content);
}

function sendTextWithKeyboardCall($buttons, $text, $backBtn = false)
{
    global $telegram, $chatID, $texts;
    $option = [];
    if (count($buttons) % 2 == 0) {
        for ($i = 0; $i < count($buttons); $i += 2) {
            $option[] = array($telegram->buildKeyboardButton($buttons[$i]), $telegram->buildKeyboardButton($buttons[$i + 1]));
        }
    } else {
        for ($i = 0; $i < count($buttons) - 1; $i += 2) {
            $option[] = array($telegram->buildKeyboardButton($buttons[$i]), $telegram->buildKeyboardButton($buttons[$i + 1]));
        }
        $option[] = array($telegram->buildKeyboardButton(end($buttons)));
    }
    if ($backBtn) {
        $option[] = [$telegram->buildKeyboardButton($texts->getText("back_btn"))];
    }
    $keyboard = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
    $content = array('chat_id' => $chatID, 'reply_markup' => $keyboard, 'text' => $text, 'parse_mode' => "HTML");
    $telegram->sendMessage($content);
}

