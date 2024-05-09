<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
$xqlurl = "https://pixelatejs.000webhostapp.com"; 

function makeid($length) {
    $result = '';
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $charactersLength = strlen($characters);
    $counter = 0;
    while ($counter < $length) {
        $result .= $characters[rand(0, $charactersLength - 1)];
        $counter += 1;
    }
    return $result;
}




function QUERY($passkey, $db, $query) {
    $xqlget = "https://pixelatejs.000webhostapp.com/getrow.php"; 

    $string = $query;
    $match2 = preg_match('/SELECT (\w+)/', $string, $matches);
    if ($match2) {
        $dataSelector = $matches[1];
        $conditionSelector = "";
        $conditionValue = "";
        $mtype = "null";
        if (strpos($string, "WHERE") !== false) {
            preg_match('/WHERE (\w+) = \'([^\']+)\'/', $string, $wmatch);
            if ($wmatch) {
                $conditionSelector = $wmatch[1];
                $conditionValue = $wmatch[2];
                $mtype = "where";
            }
        }

        if (strpos($string, "REGEX") !== false) {
            preg_match('/REGEX (\w+) = \'([^\']+)\'/', $string, $wmatch);
            if ($wmatch) {
                $conditionSelector = $wmatch[1];
                $conditionValue = $wmatch[2];
                $mtype = "regex";
            }
        }

        if (strpos($string, "INDEX") !== false) {
            preg_match('/INDEX (\w+) = \'([^\']+)\'/', $string, $wmatch);
            if ($wmatch) {
                $conditionSelector = $wmatch[1];
                $conditionValue = $wmatch[2];
                $mtype = "index";
            }
        }

        if (strpos($string, "COUNT") !== false) {
            preg_match('/COUNT (\w+) = \'([^\']+)\'/', $string, $wmatch);
            if ($wmatch) {
                $conditionSelector = $wmatch[1];
                $conditionValue = $wmatch[2];
                $mtype = "count";
            }
        }

        $path = $xqlget."?key=".$passkey."&tab=".$dataSelector."&row=".$db."&sess=".makeid(5);

        $response = file_get_contents($path);
        if ($response == "" || strpos($response, "Domain Not Allowed") !== false) {
            if (strpos($response, "Domain Not Allowed") !== false) {
                echo $response;
            }
        } else {
            $hexql = json_decode($response, true);
            if ($hexql) {
                $getData;
                $dataVal = $hexql;


if ($mtype == "null") {
                $getData = $dataVal;
            }

            if ($mtype == "where" || $mtype == "count") {
                $getData = array_filter($dataVal, function ($item) use ($conditionSelector, $conditionValue) {
                    return $item[$conditionSelector] == $conditionValue;
                });

                if (strpos($string, "OR") !== false) {
                    preg_match('/OR (\w+) = \'([^\']+)\'/', $string, $wando);
                    if ($wando) {
                        $coSelector = $wando[1];
                        $coValue = $wando[2];

                        $coData = array_filter($dataVal, function ($item) use ($coSelector, $coValue) {
                            return $item[$coSelector] === $coValue;
                        });

                        foreach ($coData as $item) {
                            $ioid = array_filter($getData, function ($tcurr) use ($item) {
                                return $tcurr === $item;
                            });
                            if (count($ioid) === 0) {
                                $getData[] = $item;
                            }
                        }

                        $getData = array_filter($dataVal, function ($item) use ($getData) {
                            return in_array($item, $getData);
                        });
                    }
                }
            }

            if ($mtype == "index") {
                $getData = array_filter($dataVal, function ($item) use ($conditionSelector, $conditionValue) {
                    return $item[$conditionSelector] === $conditionValue;
                });
            }

            if ($mtype == "regex") {
                $getData = array_filter($dataVal, function ($item) use ($conditionSelector, $conditionValue) {
                    return strpos($item[$conditionSelector], $conditionValue) !== false;
                });
            }

            $selectedData = "";
            if ($conditionSelector == "Key") {
                $fLen = count($dataVal) - 1;

                if ($conditionValue == "first") {
                    $selectedData = array_filter($dataVal, function ($obj, $index) {
                        return $index === 0;
                    });
                } else if ($conditionValue == "last") {
                    $selectedData = array_filter($dataVal, function ($obj, $index) use ($fLen) {
                        return $index === $fLen;
                    });
                } else {
                    $cVal = (int)$conditionValue - 1;
                    $selectedData = array_filter($dataVal, function ($obj, $index) use ($cVal) {
                        return $index === $cVal;
                    });
                }
            } else {
                $selectedData = $getData;
            }

            if (strpos($string, "AND") !== false) {
                preg_match('/AND (\w+) = \'([^\']+)\'/', $string, $wand);
                if ($wand) {
                    $cSelector = $wand[1];
                    $cValue = $wand[2];

                    $selectedData = array_filter($selectedData, function ($item) use ($cSelector, $cValue) {
                        return $item[$cSelector] === $cValue;
                    });
                }
            }

            foreach ($selectedData as $key => $imp) {
                $index = array_search($imp, $dataVal);
                $index = $index + 1;
                $selectedData[$key]['Key'] = $index;
            }

            if (strpos($string, "ORDER") !== false) {
                preg_match('/ORDER (\S+)/', $string, $orA);
                if ($orA) {
                    $orVal = $orA[1];

                    if (strpos($orVal, "DESC") !== false) {
                        $selectedData = array_reverse($selectedData);
                        $order = explode("-", $orVal);
                        $order = end($order);
                        if ($order !== "DESC") {
                            usort($selectedData, function ($a, $b) use ($order) {
                                return $b[$order] - $a[$order];
                            });
                        }
                    }

                    if (strpos($orVal, "RAND") !== false) {
                        shuffle($selectedData);
                    }
                }
            }

            if (strpos($string, "LIMIT") !== false) {
                preg_match('/LIMIT (\d+)/', $string, $limA);
                if ($limA) {
                    $limVa = $limA[1];
                    $selectedData = array_slice($selectedData, 0, $limVa);
                }
            }

            $count = "";
            if ($mtype == "index") {
                $selectedData = array_search($selectedData[0], $dataVal);
                $selectedData = $selectedData + 1;
            } elseif ($mtype == "count") {
                $selectedData = count($selectedData);
            } else {
                $count = count($selectedData);
            }
            




                return (array_values($selectedData));
            } else {
                echo "Empty or corrupt data";
            }
        }
    } else {
        echo 'Invalid Query';
    }
}



?>
