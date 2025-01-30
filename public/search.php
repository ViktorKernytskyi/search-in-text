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
// Лічильник появ слів
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

// Функція для перетворення символів у нижній регістр (враховуючи кирилицю)
function toLowerCase($word)
{
    $result = "";
    $i = 0;

    while (isset($word[$i])) {
        $byte = $word[$i];

        // Якщо це велика літера латиниці
        if ($byte >= 'A' && $byte <= 'Z') {
            $result .= $byte + ("a" - "A"); // Перетворюємо у малу літеру
        } // Якщо це велика літера кирилиці
        elseif ($byte === "\xD0" && isset($word[$i + 1])) {
            $secondByte = $word[$i + 1];
            if ($secondByte >= "\x90" && $secondByte <= "\x9F") { // Великі літери кирилиці
                $result .= "\xD1" . ($secondByte + ("\xB0" - "\x90"));
            } else {
                $result .= $byte . $secondByte;
            }
            $i++; // Пропускаємо наступний байт
        } elseif ($byte === "\xD1" && isset($word[$i + 1])) {
            $secondByte = $word[$i + 1];
            if ($secondByte >= "\x80" && $secondByte <= "\x8F") { // Великі літери "я", "є", "ї", "ґ"
                $result .= "\xD1" . ($secondByte + ("\x90" - "\x80"));
            } else {
                $result .= $byte . $secondByte;
            }
            $i++; // Пропускаємо наступний байт
        } else {
            $result .= $byte; // Залишаємо без змін
        }

        $i++; // Наступний байт
    }

    return $result;
}

// Лічильник появ слів
$wordCounts = [];
foreach ($words as $word) {
    $lowercaseWord = toLowerCase($word); // Перетворюємо у нижній регістр

    if (isset($wordCounts[$lowercaseWord])) {
        $wordCounts[$lowercaseWord]++; // Збільшуємо лічильник
    } else {
        $wordCounts[$lowercaseWord] = 1; // Додаємо нове слово
    }
}

// Відбираємо слова, які зустрічаються від 5 до 10 разів
$result = [];
foreach ($wordCounts as $word => $count) {
    if ($count >= 5 && $count <= 10) {
        $result[] = [$word, $count];
    }
}

// Виведення результатів
if (!empty($result)) {
    echo "Слова, які зустрічаються від 5 до 10 разів:\n";
    foreach ($result as $wordData) {
        echo "<br>" . $wordData[0] . " зустрічається - " . $wordData[1] . " разів \n";
    }
} else {
    echo "Слова не знайдено.\n";
}

?>
