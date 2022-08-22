<?php 

$username = "";
$host = "";
$password = "";
$db = "";


$con = mysqli_connect($host, $username, $password, $db);

if(isset($con)){
    echo "Yes DB";
}

class DB {
    public $con;
    public $chat_id;

    public function __construct($chat_id, $conn)
    {
        $this->chat_id = $chat_id;
        $this->con = $conn;
    }

    // Menudagi kategoriyani ko'rish user uchun
    public function GetAllProducts($section){
        global $chat_id, $telegram;
        SetPage('getproducts');
        $q = "select * from `temp_product` where chat_id = {$chat_id}";
        $r = mysqli_query($this->con, $q);
        if(mysqli_num_rows($r) > 0){
            $sql = "DELETE FROM `temp_product` WHERE chat_id = {$chat_id}";
            $s = mysqli_query($this->con, $sql);
            $sql = "INSERT INTO `temp_product`(`chat_id`, `section_id`) VALUES ({$chat_id},'{$section}')";
            $s = mysqli_query($this->con, $sql);
        }       
        else{
            $sql = "INSERT INTO `temp_product`(`chat_id`, `section_id`) VALUES ({$chat_id},'{$section}')";
            $s = mysqli_query($this->con, $sql);
        }
        $sql = "Select * from `product` where section_id = '{$section}'";
        $s = mysqli_query($this->con, $sql);
        $but = ["➕ Maxsulot qo'shish", "↪️ Orqaga"];
        if (mysqli_num_rows($s) < 1) {
            sendTextWithKeyboard($but, 'Maxsulotlar mavjud emas');
        }
        else {
            while($a = mysqli_fetch_assoc($s)){
                array_unshift($but, $a['name']);
            }
            sendTextWithKeyboard($but, 'Maxsulotni tanlang');
        }
    }

    // Admin userlarga xabar jo'natish so'rovi
    public function sendMessageUsers()
    {
        global $chat_id;
        sendTextWithKeyboard(['❌ Bekor qilish'], "Xabar yuboring!\n\nBot ushbu xabaringizni barcha foydalanuvchilarga yetkazadi.");
        SetPage('xabaryuborish');
    }

    // Admin userlarga xabar yuborish 
    public function sendMessageUsersText($text)
    {
        global $telegram;
        $row = mysqli_num_rows(mysqli_query($this->con, "select * from users"));
        $m = 0;
        for ($i=0; $i <= floor($row/15); $i++) { 
            $g = $m + 15;
            $rw = mysqli_query($this->con, "select chat_id from users LIMIT {$m},{$g}");
            while ($row = mysqli_fetch_assoc($rw)) {
                $telegram->sendMessage(['chat_id' => $row['chat_id'], 'text' => $text]);
            }
            $m = $m + 15;
        }
       sendMessage("Xabar jo'natildi");
       AStart(); 
    }

    // Admin statistika
    public function statistika()
    {
        $users = mysqli_num_rows(mysqli_query($this->con, "select * from users"));
        $orders = mysqli_fetch_assoc(mysqli_query($this->con, "SELECT SUM(summa), COUNT(chat_id) FROM `delivered`"));
        $price = number_format($orders['SUM(summa)'],0,","," ");
        $string = "<b>📈 Statistika</b>\n\n👤 Bot foydalanuvchilari: {$users} ta\n\n📤 Xizmat ko'rsatishlar soni: {$orders['COUNT(chat_id)']} ta\n\n💸 Umumiy summa: {$price} so'm";
        sendTextWithKeyboard(['📆 Sana bo\'yicha', '🗓 Ushbu kun', '📊 Ushbu oy', '↪️ Orqaga'], $string);
        SetPage('statistika');

    }

    // Statistika sana boyicha so'ro'vi
    public function statbydateRequest()
    {
        global $chat_id;
        sendTextWithKeyboard(['↪️ Orqaga'],"Sanani yuboring\n\nYil-Oy-Kun\n\nNamuna: 2022-08-01");
        SetPage('sendingdate');
    }

    // Statistika sana bo'yicha
    public function statbaydate($date)
    {
        $sql = "SELECT SUM(summa),COUNT(chat_id) FROM `delivered` WHERE `date` = '{$date}'";
        $r = mysqli_query($this->con, $sql);
        if (mysqli_num_rows($r) > 0) {
            $row = mysqli_fetch_assoc($r);
            $price = number_format($row['SUM(summa)'],0,","," ");
            sendTextWithKeyboard(['↪️ Orqaga'], "<b>📈 Statistika</b>\n\n📤 Xizmat ko'rsatishlar soni: {$row['COUNT(chat_id)']} ta\n\n💸 Umumiy summa: {$price} so'm");
            SetPage('statbydateok');
        }
        else {
            sendTextWithKeyboard(['↪️ Orqaga'], "<b>📈 Statistika</b>\n\n📤 Xizmat ko'rsatishlar soni: 0 ta\n\n💸 Umumiy summa: 0 so'm");
            SetPage('statbydateok');
        }
    }

    // statistika ushbu kun
    public function stattoday()
    {
        $date = date("Y-m-d");
        $sql = "SELECT SUM(summa),COUNT(chat_id) FROM `delivered` WHERE `date` = '{$date}'";
        $r = mysqli_query($this->con, $sql);
        if (mysqli_num_rows($r) > 0) {
            $row = mysqli_fetch_assoc($r);
            $price = number_format($row['SUM(summa)'],0,","," ");
            sendTextWithKeyboard(['↪️ Orqaga'], "<b>📈 Statistika {$date} bo'yicha</b>\n\n📤 Xizmat ko'rsatishlar soni: {$row['COUNT(chat_id)']} ta\n\n💸 Umumiy summa: {$price} so'm");
            SetPage('statbydateok');
        }
        else {
            sendTextWithKeyboard(['↪️ Orqaga'], "<b>📈 Statistika {$date} bo'yicha</b>\n\n📤 Xizmat ko'rsatishlar soni: 0 ta\n\n💸 Umumiy summa: 0 so'm");
            SetPage('statbydateok');
        }
    }

    // statistika oy bo'yicha
    public function statmonth()
    {
        $y = date("Y");
        $m = date('m');
       
        // $days = cal_days_in_month(CAL_GREGORIAN, $m, $y);
        $t = date('t');
        
        switch ($t) {
            case '31':
                $this->ottizbir();
                break;
            case '30':
                $this->ottiz();
                break;
            case '29':
                $this->yigirmatoqqiz();
                break;
            case '28':
                $this->yigirmasakkiz();
                break;
            default:
                # code...
                break;
        }
        
    }
    
    // Oy 31 dan qaytsa
    public function ottizbir()
    {
        $y = date("Y");
        $m = date("m");
        $date1 = "{$y}-{$m}-01";
        $date2 = "{$y}-{$m}-31";
        $sql = "SELECT SUM(summa),COUNT(chat_id) FROM `delivered` WHERE `date` BETWEEN '{$date1}' AND '{$date2}'";
        $r = mysqli_query($this->con, $sql);
        if (mysqli_num_rows($r) > 0) {
            $row = mysqli_fetch_assoc($r);
            $price = number_format($row['SUM(summa)'],0,","," ");
            sendTextWithKeyboard(['↪️ Orqaga'], "<b>📈 Statistika oy bo'yicha</b>\n\n📤 Xizmat ko'rsatishlar soni: {$row['COUNT(chat_id)']} ta\n\n💸 Umumiy summa: {$price} so'm");
            SetPage('statbydateok');
        }
        else {
            sendTextWithKeyboard(['↪️ Orqaga'], "<b>📈 Statistika oy bo'yicha</b>\n\n📤 Xizmat ko'rsatishlar soni: 0 ta\n\n💸 Umumiy summa: 0 so'm");
            SetPage('statbydateok');
        }
    }

    // Oy 30 dan qaytsa
    public function ottiz()
    {
        $y = date("Y");
        $m = date("m");
        $date1 = "{$y}-{$m}-01";
        $date2 = "{$y}-{$m}-30";
        $sql = "SELECT SUM(summa),COUNT(chat_id) FROM `delivered` WHERE `date` BETWEEN '{$date1}' AND '{$date2}'";
        $r = mysqli_query($this->con, $sql);
        if (mysqli_num_rows($r) > 0) {
            $row = mysqli_fetch_assoc($r);
            $price = number_format($row['SUM(summa)'],0,","," ");
            sendTextWithKeyboard(['↪️ Orqaga'], "<b>📈 Statistika oy bo'yicha</b>\n\n📤 Xizmat ko'rsatishlar soni: {$row['COUNT(chat_id)']} ta\n\n💸 Umumiy summa: {$price} so'm");
            SetPage('statbydateok');
        }
        else {
            sendTextWithKeyboard(['↪️ Orqaga'], "<b>📈 Statistika oy bo'yicha</b>\n\n📤 Xizmat ko'rsatishlar soni: 0 ta\n\n💸 Umumiy summa: 0 so'm");
            SetPage('statbydateok');
        }
    }

    // Oy 28 dan qaytsa
    public function yigirmasakkiz()
    {
        $y = date("Y");
        $m = date("m");
        $date1 = "{$y}-{$m}-01";
        $date2 = "{$y}-{$m}-28";
        $sql = "SELECT SUM(summa),COUNT(chat_id) FROM `delivered` WHERE `date` BETWEEN '{$date1}' AND '{$date2}'";
        $r = mysqli_query($this->con, $sql);
        if (mysqli_num_rows($r) > 0) {
            $row = mysqli_fetch_assoc($r);
            $price = number_format($row['SUM(summa)'],0,","," ");
            sendTextWithKeyboard(['↪️ Orqaga'], "<b>📈 Statistika oy bo'yicha</b>\n\n📤 Xizmat ko'rsatishlar soni: {$row['COUNT(chat_id)']} ta\n\n💸 Umumiy summa: {$price} so'm");
            SetPage('statbydateok');
        }
        else {
            sendTextWithKeyboard(['↪️ Orqaga'], "<b>📈 Statistika oy bo'yicha</b>\n\n📤 Xizmat ko'rsatishlar soni: 0 ta\n\n💸 Umumiy summa: 0 so'm");
            SetPage('statbydateok');
        }
    }

    // Oy 29 dan qaytsa
    public function yigirmatoqqiz()
    {
        $y = date("Y");
        $m = date("m");
        $date1 = "{$y}-{$m}-01";
        $date2 = "{$y}-{$m}-29";
        $sql = "SELECT SUM(summa),COUNT(chat_id) FROM `delivered` WHERE `date` BETWEEN '{$date1}' AND '{$date2}'";
        $r = mysqli_query($this->con, $sql);
        if (mysqli_num_rows($r) > 0) {
            $row = mysqli_fetch_assoc($r);
            $price = number_format($row['SUM(summa)'],0,","," ");
            sendTextWithKeyboard(['↪️ Orqaga'], "<b>📈 Statistika oy bo'yicha</b>\n\n📤 Xizmat ko'rsatishlar soni: {$row['COUNT(chat_id)']} ta\n\n💸 Umumiy summa: {$price} so'm");
            SetPage('statbydateok');
        }
        else {
            sendTextWithKeyboard(['↪️ Orqaga'], "<b>📈 Statistika oy bo'yicha</b>\n\n📤 Xizmat ko'rsatishlar soni: 0 ta\n\n💸 Umumiy summa: 0 so'm");
            SetPage('statbydateok');
        }
    }




    // Admin maxulot nomini kiritish so'rovi
    public function AddProductName()
    {
        global $telegram, $chat_id;
        SetPage('setname');
        sendTextWithKeyboard(['❌ Bekor qilish'], "Maxsulot nomini kiriting");
    }

    // Admin maxulot kiritishni bekor qilish
    public function CancelAdd()
    {
        global $telegram, $chat_id;
        $sql = "DELETE FROM `temp_product` WHERE chat_id = {$chat_id}";
        $s = mysqli_query($this->con, $sql);
        AMenu();
    }

    // Admin maxsulot nomini bazaga yozish
    public function SetNameDb($name)
    {
        global $telegram, $chat_id;
        $sql = "UPDATE `temp_product` SET `name`='{$name}' WHERE chat_id = {$chat_id}";
        $s = mysqli_query($this->con, $sql);
        SetPage('setprice');
        sendTextWithKeyboard(['❌ Bekor qilish'], "Maxsulot narxini kiriting");
    }

     // Admin maxsulot narxini bazaga yozish
    public function SetPriceDb($price)
    {
        global $telegram, $chat_id;
        $string = str_replace(' ', '', $price);
        $sql = "UPDATE `temp_product` SET `price`='{$string}' WHERE chat_id = {$chat_id}";
        $s = mysqli_query($this->con, $sql);
        SetPage('setphoto');
        sendTextWithKeyboard(['❌ Bekor qilish'], "Maxsulotni rasmini jo'nating");
    }

    // Admin maxsulot rasmini bazaga yozish
    public function SetPhotoDb($file_id)
    {
        global $telegram, $chat_id;
        $sql = "UPDATE `temp_product` SET `img`='{$file_id}' WHERE chat_id = {$chat_id}";
        $s = mysqli_query($this->con, $sql);
        $sql = "select * from `temp_product` where chat_id = {$chat_id}";
        $s = mysqli_query($this->con, $sql);
        $s = mysqli_fetch_assoc($s);
        $sq = "INSERT INTO `product`(`name`, `section_id`, `price`, `img`) VALUES ('{$s['name']}',{$s['section_id']},'{$s['price']}','{$s['img']}')";
        $r = mysqli_query($this->con, $sq);
        $sqq = "DELETE FROM `temp_product` WHERE chat_id = {$chat_id}";
        $t = mysqli_query($this->con, $sqq);
        sendMessage("Maxsulot qo'shildi");
        AMenu();
    }

    // Admin maxulotni ko'rish
    public function Viewproduct($product)
    {
        global $chat_id, $telegram;
        $sql1 = "select * from `product` where name = '{$product}'";
        $r = mysqli_query($this->con, $sql1);
        $row = mysqli_fetch_assoc($r);
        $price = number_format($row['price'],0,","," ");
        $sql = "UPDATE `users` SET `product_id`={$row['id']} WHERE chat_id = {$chat_id}";
        $r = mysqli_query($this->con, $sql);
        $b = ['✏️ Nomini o\'zgartirish', "💸 Narxini o'zgartirish","🖼 Rasmini o'zgartirish", "🗑 O'chirish", "↪️ Orqaga"];
        $telegram->sendPhoto(['chat_id' => $chat_id, 'photo' => $row['img'], 'caption' => "Nomi: <b>{$row['name']}</b>\nNarxi: <b>{$price}</b>", 'parse_mode' => 'html']);
        sendTextWithKeyboard($b, "Tanlang");
        SetPage("editproduct");
    }

    // Admin maxsulot nomini o'zgartirsh so'rovi
    public function EditName()
    {
        sendTextWithKeyboard(['❌ Bekor qilish'], "Yangi nomni yuboring");
        SetPage('sendingname');
    }

    // Admin maxsulot nomini o'zgartirsh va bazaga yozish
    public function updName($name)
    {
        global $telegram, $chat_id;
        $sql2 = "select * from users where chat_id = {$chat_id}";
        $r = mysqli_query($this->con, $sql2);
        $r = mysqli_fetch_assoc($r);
        $sql2 = "UPDATE `product` SET `name`='{$name}' WHERE id = {$r['product_id']}";
        $k = mysqli_query($this->con, $sql2);
        $this->Viewproduct($name);
    }

    // Admin maxsulot narxini o'zgartirsh so'rovi
    public function EditPrice()
    {
        sendTextWithKeyboard(['❌ Bekor qilish'], "Yangi narxni yuboring");
        SetPage('sendingprice');
    }

    // Admin maxsulot narxini o'zgartirsh va bazaga yozish
    public function updPrice($name)
    {
        global $telegram, $chat_id;
        $string = str_replace(' ', '', $name);
        $sql2 = "select * from users where chat_id = {$chat_id}";
        $r = mysqli_query($this->con, $sql2);
        $r = mysqli_fetch_assoc($r);
        $sql3 = "UPDATE `product` SET `price`='{$string}' WHERE id = {$r['product_id']}";
        $k = mysqli_query($this->con, $sql3);
        $this->ViewproductP();
    }

    // Admin maxsulotni ko'rish. Orqaga knopkani bosganda
    public function ViewproductP()
    {
        global $chat_id, $telegram;
        $sql = "select * from users where chat_id = {$chat_id}";
        $r = mysqli_query($this->con, $sql);
        $r = mysqli_fetch_assoc($r);
        $sql = "select * from product where id = {$r['product_id']}";
        $r = mysqli_query($this->con, $sql);
        $row = mysqli_fetch_assoc($r);
        $price = number_format($row['price'],0,","," ");
        $b = ['✏️ Nomini o\'zgartirish', "💸 Narxini o'zgartirish","🖼 Rasmini o'zgartirish", "🗑 O'chirish", "↪️ Orqaga"];
        $telegram->sendPhoto(['chat_id' => $chat_id, 'photo' => $row['img'], 'caption' => "Nomi: <b>{$row['name']}</b>\nNarxi: <b>{$price}</b>", 'parse_mode' => 'html']);
        sendTextWithKeyboard($b, "Tanlang");
        SetPage("editproduct");
    }

    // Admin rasmni o'zgartirish so'rovi
    public function EditPhoto()
    {
        sendTextWithKeyboard(['❌ Bekor qilish'], "Yangi rasmni yuboring");
        SetPage('sendingphoto');
    }

    // Admin rasmni o'zgartirish va db ga yozish
    public function updPhoto($name)
    {
        global $telegram, $chat_id;
        $sql2 = "select * from users where chat_id = {$chat_id}";
        $r = mysqli_query($this->con, $sql2);
        $r = mysqli_fetch_assoc($r);
        $sql3 = "UPDATE `product` SET `img`='{$name}' WHERE id = {$r['product_id']}";
        $k = mysqli_query($this->con, $sql3);
        $this->ViewproductP();
    }

    // Admin maxulotni o'chirish
    public function DeleteProduct()
    {
        global $telegram, $chat_id;
        $sql2 = "select * from users where chat_id = {$chat_id}";
        $r = mysqli_query($this->con, $sql2);
        $r = mysqli_fetch_assoc($r);
        $sql3 = "DELETE FROM `product` WHERE id = {$r['product_id']}";
        $k = mysqli_query($this->con, $sql3);
        AMenu();
    }

    public function AdminViewOrder($id)
    {
        global $chat_id, $telegram;
        $sqqq = "UPDATE `users` SET `order_id`='{$id}' WHERE chat_id = {$chat_id}";
        mysqli_query($this->con, $sqqq);
        $sql = "select * from `orders` where id = {$id}";
        $r = mysqli_fetch_assoc(mysqli_query($this->con, $sql));
        $sq = "select order_profuct.count, order_profuct.price, product.name from order_profuct INNER JOIN product ON product.id = order_profuct.product_id where order_profuct.chat_id = {$r['chat_id']}";
        $rd = mysqli_query($this->con, $sq);
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
        $telegram->sendLocation(['chat_id' => $chat_id, 'latitude' => $r['latitude'], 'longitude' => $r['longitude']]);
        sendTextWithKeyboard($b, $string);
        SetPage('adminvieworder');
    }

    public function delivered()
    {
        global $chat_id, $telegram;
        $r = mysqli_fetch_assoc(mysqli_query($this->con, "select order_id from users where chat_id = {$chat_id}"));
        $row = mysqli_fetch_assoc(mysqli_query($this->con, "select chat_id from orders where id = {$r['order_id']}"));
        $pow = mysqli_fetch_assoc(mysqli_query($this->con, "INSERT INTO delivered (chat_id, name, address, phone, summa)
        SELECT orders.chat_id, orders.name, orders.address, orders.phone, orders.summa
        FROM orders
        WHERE orders.id = {$r['order_id']}"));
        $content = ['chat_id' => $row['chat_id'], "text" => "Buyurtmangiz yetkazildi!\n\nSizga xizmat ko'rsatganimizdan mamnunmiz😊", 'parse_mode' => "HTML"];
        $telegram->sendMessage($content);
        $rw = mysqli_fetch_assoc(mysqli_query($this->con, "DELETE FROM `order_profuct` WHERE chat_id = {$row['chat_id']}"));
        $rw = mysqli_fetch_assoc(mysqli_query($this->con, "DELETE FROM `orders` WHERE id = {$r['order_id']}"));
        sendMessage("Buyurtma yetkazildi");
        AStart();
    }

    public function ordercansel()
    {
        global $chat_id, $telegram;
        $r = mysqli_fetch_assoc(mysqli_query($this->con, "select order_id from users where chat_id = {$chat_id}"));
        $row = mysqli_fetch_assoc(mysqli_query($this->con, "select chat_id from orders where id = {$r['order_id']}"));
        $content = ['chat_id' => $row['chat_id'], "text" => "Buyurtmangiz bekor qilindi!\n\nQaytadan buyurtma bering yoki adminlarimiz bilan bog'laning", 'parse_mode' => "HTML"];
        $telegram->sendMessage($content);
        $rw = mysqli_fetch_assoc(mysqli_query($this->con, "DELETE FROM `order_profuct` WHERE chat_id = {$row['chat_id']}"));
        $rw = mysqli_fetch_assoc(mysqli_query($this->con, "DELETE FROM `orders` WHERE id = {$r['order_id']}"));
        sendMessage("Buyurtma bekor qilindi");
        AStart();
    }

    // Admin orderslarni ko'rish
    public function Orders()
    {
        global $telegram, $chat_id;
        SetPage('aorders');
        $sql = "select * from `orders`";
        $r = mysqli_query($this->con, $sql);
        if (mysqli_num_rows($r) < 1) {
            sendMessage('Buyurmalar mavjud emas');
            AStart();
        }
        else {
            $arrays = [];
            $option = [];
            $string = "<b>Buyurtmalar:</b>\n";
            $i = 1;
            while ($row  = mysqli_fetch_assoc($r)) {
                $row['number'] = $i;
                $arrays[] = $row;
                $price = number_format($row['summa'],0,","," ");
                $string = $string."{$i}. {$row['name']} - {$price} so'm\n";
                $i += 1;
            }
            $t = count($arrays);
            $string = $string."<b>Jami buyurtmalar soni: {$t} ta</b>";
            if (mysqli_num_rows($r) % 2 == 0) {
                for ($i = 0; $i < mysqli_num_rows($r); $i += 2) {
                    $o = $i+1;
                    $option[] = array($telegram->buildInlineKeyboardButton("{$arrays[$i]['number']}","","{$arrays[$i]['id']}"), $telegram->buildInlineKeyboardButton("{$arrays[$o]['number']}","","{$arrays[$o]['id']}"));
                }
            }
            else{
                for ($i = 0; $i < mysqli_num_rows($r) - 1; $i += 2) {
                    $o = $i+1;
                    $option[] = array($telegram->buildInlineKeyboardButton("{$arrays[$i]['number']}","","{$arrays[$i]['id']}"), $telegram->buildInlineKeyboardButton("{$arrays[$o]['number']}","","{$arrays[$o]['id']}"));
                }
                $rs = count($arrays) - 1;
                $option[] = array($telegram->buildInlineKeyboardButton("{$arrays[$rs]['number']}", "","{$arrays[$rs]['id']}")); 
            }
            $keyb = $telegram->buildInlineKeyBoard($option);
            $content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, "text" => $string, 'parse_mode' => "HTML"];
            $telegram->sendMessage($content);
        }
        
    }






    
    // User maxulotlar kategoriya b
    public function getProductClinet($section_id)
    {
        global $telegram, $chat_id;
        $sql = "select name from `product` where section_id = {$section_id}";
        $r = mysqli_query($this->con, $sql);
        if (mysqli_num_rows($r) < 0) {
            sendMessage('Maxsulotlar mavjud emas');
            Menu();
        }
        else{
        $b = [];
        while ($row = mysqli_fetch_assoc($r)) {
            $b[] = $row['name'];
        }
        $b[] = "↪️ Orqaga";
        sendTextWithKeyboard($b, "Tanlang");
        SetPage('select');
        }
    }

    // User savatni ko'rish
    public function basket()
    {
        global $chat_id, $telegram;
        SetPage('basketview');
        $sql = "SELECT product.name, basket.count, basket.price FROM `basket` INNER JOIN product ON product.id = basket.product_id where basket.chat_id = {$chat_id}";
        $r = mysqli_query($this->con, $sql);
        $string = "🛒 Sizning savatdagi maxsulotlaringiz:\n";
        if (mysqli_num_rows($r) < 0) {
           sendMessage('Hozircha savatga maxulot qo\'shmagansiz');
           Start();
        }
        else{
            $summa = 0;
            while ($row = mysqli_fetch_assoc($r)) {
                $summa += $row['price'];
                $narx = number_format($row['price'],0,","," ");
                $string = $string."➖➖➖➖➖➖➖➖➖\n<b>{$row['name']} - {$row['count']} ta - {$narx} so'm</b>\n";
            }
            $summa = number_format($summa,0,","," ");
            $string = $string."➖➖➖➖➖➖➖➖➖\n<b>Umumiy summa: {$summa} so'm</b>";
            sendTextWithKeyboard(['✅ Buyurtma qilish','🖋 Taxrirlash','↪️ Orqaga'], $string);
        }
    }

    // User basket edit
    public function basketEdit()
    {
        global $telegram, $chat_id;
        SetPage('basketviewedit');
        $sql = "SELECT product.name, product.id, basket.count, basket.price FROM `basket` INNER JOIN product ON product.id = basket.product_id where basket.chat_id = {$chat_id}";
        $r = mysqli_query($this->con, $sql);
        $arrays = [];
        $option = [];
        $string = "<b>Buyurtmalar:</b>\n";
        $i = 1;
        $string = "🛒 Sizning savatdagi maxsulotlaringiz:\n";
        sendTextWithKeyboard(['↪️ Orqaga'], $string);
        $string = "\n";
        $sum = 0;
        while ($row  = mysqli_fetch_assoc($r)) {
            $row['number'] = $i;
            $arrays[] = $row;
            $sum += $row['price'];
            $price = number_format($row['price'],0,","," ");
            $string = $string."{$i}. {$row['name']} - {$row['count']} ta - {$price} so'm\n";
            $i += 1;
        }
        $sum = number_format($sum,0,","," ");
        $t = count($arrays);
        $string = $string."\n<b>Jami buyurtmalar soni: {$t} ta \n\nUmumiy narx: {$sum}</b>\n\n <b>Nechanchi buyurtmani taxrirlaysiz. Tugmani bosing</b>";
        if (mysqli_num_rows($r) % 2 == 0) {
            for ($i = 0; $i < mysqli_num_rows($r); $i += 2) {
                $o = $i+1;
                $option[] = array($telegram->buildInlineKeyboardButton("{$arrays[$i]['number']}","","{$arrays[$i]['id']}"), $telegram->buildInlineKeyboardButton("{$arrays[$o]['number']}","","{$arrays[$o]['id']}"));
            }
        }
        else{
            for ($i = 0; $i < mysqli_num_rows($r) - 1; $i += 2) {
                $o = $i+1;
                $option[] = array($telegram->buildInlineKeyboardButton("{$arrays[$i]['number']}","","{$arrays[$i]['id']}"), $telegram->buildInlineKeyboardButton("{$arrays[$o]['number']}","","{$arrays[$o]['id']}"));
            }
            $rs = count($arrays) - 1;
            $option[] = array($telegram->buildInlineKeyboardButton("{$arrays[$rs]['number']}", "","{$arrays[$rs]['id']}")); 
        }
        $keyb = $telegram->buildInlineKeyBoard($option);
        $content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, "text" => $string, 'parse_mode' => "HTML"];
        $telegram->sendMessage($content);
    }


    public function editbasketproduct($id)
    {
        global $telegram, $chatID;
        SetPageCall('editbasketproduct', $chatID);
        $sqll = "SELECT product.name, product.id, basket.count, basket.price, product.img FROM `basket` INNER JOIN product ON product.id = basket.product_id where basket.chat_id = {$chatID} and basket.product_id = {$id}";
        $sql = "select * from basket where chat_id = {$chatID} and product.im";
        $r = mysqli_query($this->con, $sqll);
        $row = mysqli_fetch_assoc($r);
        $price = number_format($row['price'],0,","," ");
        $btta = $row['price'] / $row['count'];
        $btta = number_format($btta,0,","," ");
        $sql = "UPDATE `users` SET `product_id`={$id} WHERE chat_id = {$chatID}";
        $rs = mysqli_query($this->con, $sql);
        $telegram->sendPhoto(['chat_id' => $chatID, 'photo' => $row['img'], 'caption' => "Nomi: <b>{$row['name']}</b>\n1 ta maxsulot narxi: <b>{$btta}</b>\nMiqdori: <b>{$row['count']}</b>\nNarxi: <b>{$price}</b>", 'parse_mode' => 'html']);
        sendTextWithKeyboardCall(["🖋 Miqdorini o'zgartish",'❌ Savatdan olib tashlash','↪️ Orqaga'], "Tugmalardan birini tanlang");
    }

    public function EditCountUser()
    {
        $b = ['↪️ Orqaga'];
        sendTextWithKeyboard($b,"<b>Ushbu maxsulotdan qancha miqdorda buyurtma qilasiz? Miqdorni yuboring ⬇️\n\n</b>❕ Eslatma: Faqat raqam yuboring(0.5, 1, 1.5, 2)");
        SetPage('sendeditcount');
    }

    public function saveLocation()
    {
        global $telegram, $latitude, $longitude, $chat_id, $message;
        if($latitude != null && $latitude != ''){
            mysqli_query($this->con, "DELETE FROM `orders` WHERE chat_id = {$chat_id}");
            $sql = "INSERT INTO `orders`(`chat_id`, `name`, `latitude`, `longitude`) VALUES ({$chat_id},'{$message['from']['first_name']}','{$latitude}','{$longitude}')";
            mysqli_query($this->con, $sql);
            SetPage('sendaddress');
            $b = ['❌ Bekor qilish'];
            sendTextWithKeyboard($b, "Manzilingizni yozib yuboring (Masalan: 4 - mikrorayon. 12-uy 1-xonadon)");
        }
        else{
            sendMessage("Quidagi tugmalardan birini bosing⬇️");
        }
    }

    public function saveaddress($text)
    {
        global $chat_id;
        mysqli_query($this->con, "UPDATE `orders` SET `address`='{$text}' WHERE chat_id = {$chat_id}");
        $b = ['❌ Bekor qilish'];
        sendTextWithKeyboard($b, "Bo'glanish uchun raqamingizni yozib yuboring"); 
        SetPage("savenumber");
    }

    public function myOrders()
    {
        global $chat_id, $telegram;
        
            $ro = mysqli_query($this->con, "SELECT * FROM `orders` WHERE chat_id = {$chat_id}");
            $t = mysqli_fetch_assoc($ro);
            if (mysqli_num_rows($ro) > 0) {
            sendMessage("Sizda buyurma mavjud emas. Tezroq buyurtma bering. Bizni tanlab adashmaysiz😉");
            Menu();
            }
            else{
                $string = "Sizning buyurtma qilgan maxsulotlaringiz:\n";
                SetPage('myOrders');
                $summa = 0;
                $r = mysqli_query($this->con, "SELECT product.name, order_profuct.count, order_profuct.price FROM `order_profuct` INNER JOIN product ON product.id = order_profuct.product_id WHERE order_profuct.chat_id = {$chat_id}");
                while ($row = mysqli_fetch_assoc($r)) {
                    $summa += $row['price'];
                    $narx = number_format($row['price'],0,","," ");
                    $string = $string."➖➖➖➖➖➖➖➖➖\n<b>{$row['name']} - {$row['count']} ta - {$narx} so'm</b>\n";
                }
                $summa = number_format($summa,0,","," ");
                $string = $string."➖➖➖➖➖➖➖➖➖\n<b>Umumiy summa: {$summa} so'm\n\nBuyurtma holati: {$t['status']}</b>";
                sendTextWithKeyboard(['↪️ Orqaga'], $string);
            }
    }
}







