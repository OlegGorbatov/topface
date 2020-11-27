<?php
/**
 * Условия задачи (как я понял):
 * Входит ли доменное имя A в домен, идентифицируемый доменным именем B в соответствии с RFC 1034
 *
 * Входит означает, что домен идентифицируется доменным именем и состоит из той части пространства доменных имен,
 * которая находится на уровне или ниже доменного имени, определяющего домен.
 *
 * В DNS-именах допускаются символы и в нижнем, и в верхнем регистре, однако, регистр не имеет никакого смысла.
 * То есть, пара имен с одинаковым буквенным значением, но разными регистрами трактуется как пара идентичных имен.)
 *
 * @param string $inpDomain
 * @param string $inpSubDomain
 * @return bool
 */

function checkDomainIncluding(string $inpDomain, string $inpSubDomain): bool
{
    //Удаляем вначале http и https если пользователь их ввёл
    $domain = preg_replace('/(http\:\/\/|https\:\/\/|\/\/)/', '', trim($inpDomain));
    $subDomain = preg_replace('/(http\:\/\/|https\:\/\/|\/\/)/', '', trim($inpSubDomain));

    $pos = strpos($subDomain, $domain);
    if ($pos === false) {
        return false;
    } else {
        //проверяем соответствие по уровням
        $domain = array_reverse(explode('.', $domain));
        $subDomain = array_reverse(explode('.', $subDomain));

        for($i = 0; $i<count($domain); $i++ ){
            if ($domain[$i] === $subDomain[$i]){
                continue;
            } else {
                return false;
            }
        }
        return true;
    }

    //$tmp =
}
//TESTS
$rootDomain = 'foo.com';

//true
$inputDomainA = 'http://x.foo.com';
$inputDomainB = 'x.y.foo.com';
$inputDomainC = 'foo.com';

//false
$inputDomainD = 'bar.com';
$inputDomainE = 'x.baz.com';
$inputDomainF = 'foo.com.b.c';

if (checkDomainIncluding($rootDomain, $inputDomainA)) echo 'Domain A include in rootDomain <br />';
else echo 'Domain A NOT include in rootDomain <br />';

if (checkDomainIncluding($rootDomain, $inputDomainB)) echo 'Domain B include in rootDomain <br />';
else echo 'Domain B NOT include in rootDomain <br />';

if (checkDomainIncluding($rootDomain, $inputDomainC)) echo 'Domain C include in rootDomain <br />';
else echo 'Domain C NOT include in rootDomain <br />';

if (checkDomainIncluding($rootDomain, $inputDomainD)) echo 'Domain D include in rootDomain <br />';
else echo 'Domain D NOT include in rootDomain <br />';

if (checkDomainIncluding($rootDomain, $inputDomainE)) echo 'Domain E include in rootDomain <br />';
else echo 'Domain E NOT include in rootDomain <br />';

if (checkDomainIncluding($rootDomain, $inputDomainF)) echo 'Domain F include in rootDomain <br />';
else echo 'Domain F NOT include in rootDomain <br />';