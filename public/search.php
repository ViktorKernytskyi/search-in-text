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
$wordCounts = [];
foreach ($words as $word) {
    $lowercaseWord = $word; // Перетворюємо на той самий регістр (без вбудованих функцій)
    $keyExists = false;

    // Перевіряємо, чи вже є це слово в лічильнику
    foreach ($wordCounts as $key => $value) {
        if ($key === $lowercaseWord) {
            $wordCounts[$key]++; // Збільшуємо лічильник

            $keyExists = true;
            break;
        }

    }

    // Якщо слова ще немає в лічильнику, додаємо його
    if (!$keyExists) {
        $wordCounts[$lowercaseWord] = 1;
    }
}

// Відбираємо слова, які зустрічаються від 5 до 10 разів
$result = [];
foreach ($wordCounts as $word => $count) {
    if ($count >= 5 && $count <= 10) {
        $result[] = $word;
    }
}
// Виведення результатів
if (!empty($result)) {
    echo "Слова, які зустрічаються від 5 до 10 разів:\n";
    foreach ($result as $word) {
        echo "<br>" . $word ." зустрічається - " . $wordCounts[$word] ." ". "раз". "\n";
    }
} else {
    echo "Слова не знайдено.\n";
}


?>
