<?php
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Чайлд Ли Джекович',
        'job' => 'writer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
    [
        'fullname' => 'Сталлоне Сильвестр Селиверстович',
        'job' => 'actor',
    ],
];

// получим произвольное значение ФИО из исходного массива
function getRandomFullname($arr) {
    $i = rand(0, (count($arr)-1));
    return $arr[$i]['fullname'];
}
// в результате получим строку, содержащую произвольные ФИО из исходного массива
$fullname = getRandomFullname($example_persons_array);


// ФУНКЦИЯ РАЗБИЕНИЯ ФИО
// из результата предыдущей функции, принимает аргументом строку $fullname, возращает массив
function getPartsFromFullname($string) {
	$named_keys = ['surname', 'name', 'patronomyc'];
	$persons_fullname_array = array_combine($named_keys, explode(' ', $string));
	return $persons_fullname_array;
}
// присвоим полученный массив переменной для последующего использования
$result = getPartsFromFullname($fullname);
// выведем результат
print_r($result);

// ФУНКЦИЯ СБОРА ФИО ИЗ ЧАСТЕЙ
function getFullnameFromParts($surname, $name, $patronomyc) {
	return $surname.' '.$name.' '.$patronomyc;
}
// вычисляем аргументы для функции getFullnameFromParts из результата предыдущей функции (из переменной $result)
$surname = $result['surname'];
$name = $result['name'];
$patronomyc = $result['patronomyc'];
// добавим полученные аргументы в функцию и напечатаем результат - строку
$string = getFullnameFromParts($surname, $name, $patronomyc);
print_r($string."\n");

// ФУНКЦИЯ УКОРАЧИВАНИЯ ИМЕНИ
// как аргумент строка с полными ФИО
function getShortName($string) {
    // разобьем строку на отдельные элементы: фамилия, имя и отчество
	$arr = getPartsFromFullname($string);
    // получим имя и первую букву фамилии
	$short_name = $arr['name'];
	$short_surname = mb_substr($arr['surname'], 0, 1);
	return $short_name .' '. $short_surname .'.';
}
// добавим аргументы в функцию и выведем результат Имя Ф. без отчества
$getShortName = 'getShortName';
echo "<p>{$getShortName($string)}</p>";

// ФУНКЦИЯ ОПРЕДЕЛЕНИЯ ПОЛА ПО ИМЕНИ
//аргумент произвольная строка из исходного массива, полученная функцией getRandomFullname
function getGenderFromName($string) {
	$gender = 'Пол: ';
	$gender_sign = 0;
// разобьем полученную строку с ФИО на части
	$fullname_arr = getPartsFromFullname ($string);
// получим нужные для определения пола окончания фамилии, имени и отчества
	$surname_end = mb_substr($fullname_arr['surname'], -1, 1);
	$name_end = mb_substr($fullname_arr['name'], -1, 1);
	$patronomyc_end = mb_substr($fullname_arr['patronomyc'], -2, 2);
 // в зависимости от окончаний ФИО обновим признак пола
	if  ($surname_end === 'а' || $name_end === 'а' || $patronomyc_end === 'на') {
		$gender_sign -= 1;
	} elseif ($surname_end === 'в' || $name_end === 'н' || $patronomyc_end === 'ич') {
		$gender_sign += 1;
	}
// можно использовать космический корабль, как написано в задании
	// if (($gender_sign <=> 0) == 1) {
	// 	$gender .= 'мужской';
	// } elseif (($gender_sign <=> 0) == -1) {
	// 	$gender .= 'женский';
	// } else {
	// 	$gender .= 'не определен';	
	// }
 // по значению признака пола определим пол
 // так короче
	if ($gender_sign > 0) {
		$gender .= 'мужской';
	} elseif ($gender_sign < 0) {
		$gender .= 'женский';
	} else {
		$gender .= 'не определен';	
	}

	return $gender;
}
// выведем результат определения пола
$getGenderFromName = 'getGenderFromName';
echo "<p>{$getGenderFromName($string)}</p>";

// создадим функцию для подсчеита длины полученных массивов и исходного массива и посчитаем процентное соотношение
function percent_count($gender_array, $arr) {
	$percent = round((count($gender_array)/count($arr))*100, 1).'%';
	return $percent;
}

// ФУНКЦИЯ ОПРЕДЕЛЕНИЯ ПОЛОВОГО СОСТАВА
function getGenderDescription($arr) {
// получим массив с мужскими именами
	$men_array = array_filter($arr, function ($value) {
	if (getGenderFromName($value['fullname']) === 'Пол: мужской'){
		return $value;
	}
	});
// получим массив с женскими именами
	$women_array = array_filter($arr, function ($value) {
	if (getGenderFromName($value['fullname']) === 'Пол: женский'){
		return $value;
	}
	});
// получим массив с именами, пол которых не определен
	$noGender_array = array_filter($arr, function ($value) {
	if (getGenderFromName($value['fullname']) === 'Пол: не определен'){
		return $value;
	}
	});
	$men_percent = percent_count($men_array, $arr); 
	$women_percent = percent_count($women_array, $arr);
	$noGender_percent = percent_count($noGender_array, $arr);
// подставим значения в текст
echo "<p>
Гендерный состав аудитории:<br>
-------------------------------------<br>
Мужчины - {$men_percent}<br>
Женщины - {$women_percent}<br>
Не удалось определить - {$noGender_percent}</p>";
}
// выведем результат
print_r(getGenderDescription($example_persons_array));


// создадим функцию, которая приводит ввод ФИО к нужному нам регистру, используем в функции getPerfectPartner
function rightCase($word) {
	$word = mb_convert_case($word, MB_CASE_TITLE_SIMPLE);
	return $word;
}

// создадим функцию подсчета рандомных процентов идеальности, используем в функции getPerfectPartner
function getPerfectPercent() {
	$max_percent = 100;
	$current_percent = rand(50, 100).'.'.rand(0, 9).rand(0, 9);
	if ($current_percent > $max_percent)
	return $max_percent.'.'.'00';
	else return $current_percent;
}


// ПОДБОР ИДЕАЛЬНОЙ ПАРЫ
// аргументы: фамилия, имя, отчество отдельными строками (объявлены выше) и исходный массив $example_persons_array
function getPerfectPartner($surname, $name, $patronomyc, $arr) {
// преобразуем некорректный ввод ФИО
	$first_partner_surname = rightCase($surname);
	$first_partner_name = rightCase($name);
	$first_partner_patronomyc = rightCase($patronomyc);
// соберем части ФИО первого партнера в целые ФИО
	$first_partner_fullname = getFullnameFromParts($first_partner_surname, $first_partner_name, $first_partner_patronomyc);
// определим пол первого партнера по имени
	$first_partner_gender = getGenderFromName($first_partner_fullname);
// исключим из вывода ФИО чей пол не определен
	while ($first_partner_gender === 'Пол: не определен'){
	$first_partner_fullname = getRandomFullname($arr);
	$first_partner_gender = getGenderFromName($first_partner_fullname);
	}
// выберем произвольно человека с противоположным полом из исходного массива 
	$second_partner_name = getRandomFullname($arr);
	$second_partner_gender = getGenderFromName($second_partner_name);
// если пол такой же как у первого партнера или не определен, то продолжаем выбирать
	while ($second_partner_gender === $first_partner_gender || $second_partner_gender === 'Пол: не определен') {
	$second_partner_name = getRandomFullname($arr);
	$second_partner_gender = getGenderFromName($second_partner_name);
	}
// получим имя вторго партнера и поправим регистр имени, на всякий случай
	$second_partner_fullname = rightCase($second_partner_name);
// укоротим имена партнеров до вида Имя Ф.
	$first_partner_short_name = getShortName($first_partner_fullname);
	$second_partner_short_name = getShortName($second_partner_fullname);
// вычислим произвольный процент идеальности от 50 до 100 с двумя знаками после запятой
	$perfect_percent = getPerfectPercent().'%';
// подставим полученные данные в текст
// подставим полученные данные в текст
echo "<p>{$first_partner_short_name} + {$second_partner_short_name} = <br>
♡ Идеально на {$perfect_percent} ♡</p>";
}
// выведем результат
print_r(getPerfectPartner($surname, $name, $patronomyc, $example_persons_array)."\n");