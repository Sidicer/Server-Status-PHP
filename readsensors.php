<?php 

// Usage: https://github.com/Sidicer/lm-sensors-php
// created by https://github.com/divinity76 (https://stackoverflow.com/users/1067003/hanshenrik)

function read_sensors(): array
{
    $raw = shell_exec("sensors -u");
    $things_raw = array_filter(array_map('trim', explode("\n\n", $raw)), 'strlen');
    $things_parsed = array();
    foreach ($things_raw as $thing_raw) {
        $thing = array();
        $lines = explode("\n", $thing_raw);
        $thing['name'] = trim($lines[0]);
        for ($key = 1; $key < count($lines); ++ $key) {
            $line = $lines[$key];
            if (false === strpos($line, ":")) {
                throw new RuntimeException("failed to understand line {$key} (did not contain colon where expected), line content: {$line}");
            }
            $line = trim($line);
            if (substr($line, - 1) === ":") {
                // new category...
                $cat = substr($line, 0, - 1);
                // var_dump("CAT:",$cat,$lines[$key+1],rtrim($lines[$key+1]) !== $lines[$key+1]);
                while ($key < (count($lines) - 1) && ltrim($lines[$key + 1]) !== $lines[$key + 1]) {
                    ++ $key;
                    $curr = trim($lines[$key]);
                    if (false === stripos($curr, ':')) {
                        throw new \RuntimeException("failed to understand line {$key} (did not contain colon where expected #2), line content: {$line}");
                    }
                    $curr = array_map("trim", explode(":", $curr, 2));
                    if (0 === strpos($curr[0], $cat . "_")) {
                        $curr[0] = trim(substr($curr[0], strlen($cat) + 1));
                    } else {
                        // happens on CPU sometimes.. throw new \RuntimeException("expected line {$key} to start with \"{$cat}_\", but it did not! line content: {$lines[$key]}");
                    }
                    $validated_number = filter_var($curr[1], FILTER_VALIDATE_FLOAT);
                    if (false === $validated_number) {
                        throw new \RuntimeException("failed to understand line {$key} (expected number, but could not parse as int/float), line content: {$line}");
                    }
                    if (floor($validated_number) === $validated_number) {
                        $validated_number = (int) $validated_number;
                    }
                    $thing[$cat][$curr[0]] = $validated_number; // = $curr[1];
                }
            } else {
                // Adapter: PCI adapter
                $exp = explode(":", $line, 2);
                $exp = array_map("trim", $exp);
                $thing[$exp[0]] = $exp[1];
            }
        }
        $things_parsed[] = $thing;
    }
    return $things_parsed;
}