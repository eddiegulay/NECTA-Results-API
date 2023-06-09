# NECTA API

The NECTA API is a PHP-based API that provides access to national results from schools in Tanzania for the years 2021 to 2023. It allows you to retrieve data about schools and their respective results from the National Examination Council of Tanzania (NECTA).

## Features

- Retrieve national results from schools in Tanzania for specific years.
- Get detailed information about schools and their results.
- Search for schools and results based on various criteria.
- Access data in a standardized format for easy integration with other applications.

## Requirements

- PHP 7.0 or higher
- Composer (Dependency Manager)


## Getting Examination centers
    
```php
require 'centers.php';
// get_centers(year, json){
//     year: year of examination
//     json: true or false
//}
$centers = get_centers(2021);
print_r($centers);
```

### Output
returned data is in groups of threes (each row has 3 **centers data**)


```php
[0] => Array
        (
            [0] => Array
                (
                    [number] => 0101
                    [reg_no] => P0101
                    [name] => P0101 AZANIA CENTRE
                    [link] => https://onlinesys.necta.go.tz/results/2021/csee/results/p0101.htm
                )

            [1] => Array
                (
                    [number] => 0104
                    [reg_no] => P0104
                    [name] => P0104 BWIRU BOYS CENTRE
                    [link] => https://onlinesys.necta.go.tz/results/2021/csee/results/p0104.htm
                )

            [2] => Array
                (
                    [number] => 0108
                    [reg_no] => P0108
                    [name] => P0108 IFUNDA CENTRE
                    [link] => https://onlinesys.necta.go.tz/results/2021/csee/results/p0108.htm
                )

        )
...
```

## Getting School results
```php
require 'school.php';

$year = 2021;
$school_reg_no = "p0104";

$res = get_school_results($school_reg_no, $year);
```
## Output
```php
Array
(
    [0] => Array
        (
            [CNO] => CNO
            [SEX] => SEX
            [AGGT] => AGGT
            [DIV] => DIV
            [DETAILED SUBJECTS] => DETAILED SUBJECTS
        )

    [1] => Array
        (
            [CNO] => P0104/0001
            [SEX] => F
            [AGGT] => -
            [DIV] => IV
            [DETAILED SUBJECTS] => CIV - 'C' HIST - 'D' GEO - 'D' BIO - 'D'
        )

    [2] => Array
        (
            [CNO] => P0104/0002
            [SEX] => F
            [AGGT] => 35
            [DIV] => 0
            [DETAILED SUBJECTS] => CIV - 'F' HIST - 'F' GEO - 'F' KISW - 'F' ENGL - 'F' CHEM - 'F' BIO - 'F'
        )

    [3] => Array
        (
            [CNO] => P0104/0003
            [SEX] => F
            [AGGT] => -
            [DIV] => IV
            [DETAILED SUBJECTS] => GEO - 'D' BIO - 'D'
        )
...
```
# Important
The API only support 2020 and 2021 csee results for now. We are working on adding more years.

# Contibutors   
- [Eddie Gulay](https://github.com/eddiegulay)
- [Gloria Madunda]()