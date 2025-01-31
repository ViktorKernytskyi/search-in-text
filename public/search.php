<?php
// Початковий текст
$text = "Це текст з тексту, де текст повторюється кілька разів.
 Текст, текст, текст, текст, текст! Ох,ох,ох,ох,ох,ох,ох.
 лол, лол, лол, лол,  лол, лол";

// Масив для збереження слів
$words = [];
$currentWord = "";
$index = 0;

// Обробляємо текст посимвольно
while (isset($text[$index])) {
    $byte = $text[$index];

    // Перевіряємо, чи це початок нового UTF-8 символу (перший байт)
    if (($byte & "\xC0") !== "\x80") {
        // Якщо це літера (спрощена перевірка для кирилиці та латиниці)
        if (
            ($byte >= "\xD0" && $byte <= "\xD3") || // Кирилиця
            ($byte >= 'A' && $byte <= 'Z') ||       // Великі літери латиниці
            ($byte >= 'a' && $byte <= 'z')          // Малі літери латиниці
        ) {
            $currentWord .= $byte;
        } else {
            // Якщо зустріли пробіл або символ, завершуємо поточне слово
            if ($currentWord !== "") {
                $words[] = $currentWord;
                $currentWord = "";
            }
        }
    } else {
        // Якщо це частина багатобайтового символу, додаємо до поточного слова
        $currentWord .= $byte;
    }

    $index++; // Наступний байт
}

// Додаємо останнє слово, якщо залишилося
if ($currentWord !== "") {
    $words[] = $currentWord;
}

// Відбираємо слова довжиною від 5 до 7 символів
$result = [];
foreach ($words as $word) {
    $charCount = 0; // Лічильник символів у слові
    $i = 0;

    // Рахуємо символи у слові
    while (isset($word[$i])) {
        $byte = $word[$i];

        // Перевіряємо, чи це початок символу
        if (($byte & "\xC0") !== "\x80") {
            $charCount++; // Збільшуємо лічильник символів
        }

        $i++; // Наступний байт
    }

    // Додаємо слово, якщо воно має від 5 до 7 символів
    if ($charCount >= 5 && $charCount <= 7) {
        $result[] = $word;
    }
}

// Виведення результатів
if (!empty($result)) {
    echo "Слова довжиною від 5 до 7 символів:\n";
    foreach ($result as $word) {
        echo "<br>" . $word . "\n";
    }
} else {
    echo "Слова не знайдено.\n";
}
echo "<br>";
echo '--------------------------';
echo "<br>";

$text = "Це текст з тексту, де текст повторюється кілька разів.
 Текст, текст,текст,текст! ох,Ох,ох,ох,ох,ох,ох,ох,Ох.
 лол, лол, лол, лол, лол, лол, Лол, ЛОЛ";

// Масив для збереження слів
$words = [];
$currentWord = "";
$index = 0;

// Обробляємо текст посимвольно
while (isset($text[$index])) {
    $byte = $text[$index];

    // Перевіряємо, чи це початок нового UTF-8 символу (перший байт)
    if (($byte & "\xC0") !== "\x80") {
        // Якщо це літера (спрощена перевірка для кирилиці та латиниці)
        if (
            ($byte >= "\xD0" && $byte <= "\xD3") || // Кирилиця
            ($byte >= 'A' && $byte <= 'Z') ||       // Великі літери латиниці
            ($byte >= 'a' && $byte <= 'z')          // Малі літери латиниці
        ) {
            $currentWord .= $byte;
        } else {
            // Якщо зустріли пробіл або символ, завершуємо поточне слово
            if ($currentWord !== "") {
                $words[] = $currentWord;
                $currentWord = "";
            }
        }
    } else {
        // Якщо це частина багатобайтового символу, додаємо до поточного слова
        $currentWord .= $byte;
    }

    $index++; // Наступний байт
}

// Додаємо останнє слово, якщо залишилося
if ($currentWord !== "") {
    $words[] = $currentWord;
}
function toLowerCase($word) {
    $result = "";
    $i = 0;

    while (isset($word[$i])) {
        $byte = $word[$i];

        // Перевіряємо, чи це перший байт кириличної літери
        if ($byte === "\xD0" && isset($word[$i + 1])) {
            $secondByte = $word[$i + 1];

            // Перетворюємо А-П (0x90 - 0x9F)
            if ($secondByte >= "\x90" && $secondByte <= "\x9F") {
                $result .= "\xD0" . chr(ord($secondByte) + 32);
            }
            // Перетворюємо Р-Я (0xA0 - 0xAF)
            elseif ($secondByte >= "\xA0" && $secondByte <= "\xAF") {
                $result .= "\xD1" . chr(ord($secondByte) - 32);
            } else {
                $result .= $byte . $secondByte;
            }

            $i++; // Пропускаємо наступний байт
        }
        // Перетворення великих латинських літер
        elseif ($byte >= 'A' && $byte <= 'Z') {
            $result .= chr(ord($byte) + 32);
        }
        // Якщо це просто символ або вже маленька літера
        else {
            $result .= $byte;
        }

        $i++; // Переходимо до наступного байта
    }

    return $result;
}

//// **Тестуємо коректність роботи**
//$testWords = ["ТЕКСТ", "ОХ", "ЛОЛ", "текст", "ох", "лол"];
//foreach ($testWords as $w) {
//    echo "До: $w => Після: " . toLowerCase($w) . "\n";
//}
$wordCounts = [];
foreach ($words as $word) {
    $lowercaseWord = toLowerCase($word); // Перетворюємо у нижній регістр

    if (isset($wordCounts[$lowercaseWord])) {
        $wordCounts[$lowercaseWord]++; // Збільшуємо лічильник
    } else {
        $wordCounts[$lowercaseWord] = 1; // Додаємо нове слово
    }
}

$result = [];
foreach ($wordCounts as $word => $count) {
    if ($count >= 5 && $count <= 10) {
        $result[] = $word;
    }
}

// Виведення результатів
if (!empty($result)) {
    echo "Слова, які зустрічаються від 5 до 10 разів:<br>";
    foreach ($result as $word) {
        echo "$word зустрічається - " . $wordCounts[$word] . " раз(ів)<br>";
    }
} else {
    echo "Слова не знайдено.<br>";
}
