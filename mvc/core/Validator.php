<?php

namespace Core;

/**
 * @todo: comment
 */
class Validator
{

    private array $types = [
        'letters' => '/^[a-zA-Z ]*$/',
        'text' => '/^[a-zA-Z .,#\-_|;:?!]*$/',
        'textnum' => '/^[\w\s .,#\-_|;:?!]*$/',
        'alphanumeric' => '/^[^-_]{1}[a-zA-Z0-9-_]*$/',
        'checkbox' => '/^(on|true|checked|1)$/i'
    ];

    private array $numericTypes = [
        'numeric' => 'is_numeric',
        'int' => 'is_int',
        'float' => 'is_float'
    ];

    private array $errorMessages = [
        'letters' => '%s darf nur Buchstaben und Leerzeichen beinhalten.',
        'text' => '%s darf nur Buchstaben und Sonderzeichen beinhalten.',
        'textnum' => '%s darf nur aus alphanumerischen Zeichen bestehen.',
        'alphanumeric' => '%s darf nur Buchstaben, Zahlen, Binde- und Unterstriche beinhalten.',
        'numeric' => '%s muss numerisch sein.',
        'int' => '%s muss ganzzahlig sein.',
        'float' => '%s muss eine Fließkommazahl sein.',
        'equals' => '%s muss ident sein mit %s.',

        'required' => '%s ist ein Pflichtfeld.',
        'min' => '%s muss mindestens %s sein.',
        'min-string' => '%s muss mindestens %s Zeichen haben.',
        'max' => '%s muss kleiner oder gleich %s sein.',
        'max-string' => '%s darf maximal %s Zeichen haben.',
        'compare' => '%s und %s müssen ident sein.',
        'unique' => '%s darf nur einmal verwendet werden.'
    ];

    private array $errors = [];

    public function __call($name, $arguments)
    {
        $type = $name;

        [$value, $label, $required, $min, $max] = $this->mergeDefaults($arguments);

        $this->validateRequired($required, $value, $label);

        if ($required === true || !empty($value)) {
            $this->validateMin($type, $min, $value, $label);
            $this->validateMax($type, $max, $value, $label);

            if ($this->isNumericType($type)) {
                $this->validateNumericType($type, $value, $label);
            } else {
                $this->validateWithRegex($type, $value, $label);
            }
        }
    }

    public function compare(array $valueAndLabel1, array $valueAndLabel2): bool
    {
        [$value1, $label1] = $valueAndLabel1;
        [$value2, $label2] = $valueAndLabel2;

        if ($value1 !== $value2) {
            $this->errors[] = sprintf($this->errorMessages['compare'], $label1, $label2);
            return false;
        }

        return true;
    }

    public function unique(string $value, string $label, string $table, string $column): bool
    {
        $database = new Database();
        $result = $database->query("SELECT COUNT(*) AS count FROM $table WHERE $column = ?", [
            's:value' => $value
        ]);

        if ($result[0]['count'] >= 1) {
            $this->errors[] = sprintf($this->errorMessages['unique'], $label);
            return false;
        }

        return true;
    }

    /**
     * @param bool   $required
     * @param mixed  $value
     * @param string $label
     *
     * @return bool
     */
    private function validateRequired(bool $required, mixed $value, string $label): bool
    {
        if ($required === true && empty($value)) {
            $this->errors[] = sprintf($this->errorMessages['required'], $label);
            return false;
        }
        return true;
    }

    private function mergeDefaults(array $arguments): array
    {
        $defaults = [
            0 => 'text',
            'label' => 'Feld',
            'required' => false,
            'min' => null,
            'max' => null
        ];

        $mergedArguments = [];

        $i = 0;
        foreach ($defaults as $index => $value) {
            if (isset($arguments[$index])) {
                $mergedArguments[$i] = $arguments[$index];
            } else {
                $mergedArguments[$i] = $defaults[$index];
            }
            $i++;
        }

        return $mergedArguments;
    }

    /**
     * @param mixed $type
     * @param mixed $min
     * @param mixed $value
     * @param mixed $label
     *
     * @return bool
     */
    private function validateMin(mixed $type, ?int $min, mixed $value, mixed $label): bool
    {
        if ($min !== null) {
            if ($this->isNumericType($type) && $value < $min) {
                $this->errors[] = sprintf($this->errorMessages['min'], $label, $min);
                return false;
            }

            if (!$this->isNumericType($type) && strlen($value) < $min) {
                $this->errors[] = sprintf($this->errorMessages['min-string'], $label, $min);
                return false;
            }
        }
        return true;
    }

    /**
     * @param mixed    $type
     * @param int|null $max
     * @param mixed    $value
     * @param mixed    $label
     *
     * @return bool
     */
    private function validateMax(mixed $type, ?int $max, mixed $value, mixed $label): bool
    {
        if ($max !== null) {
            if ($this->isNumericType($type) && $value > $max) {
                $this->errors[] = sprintf($this->errorMessages['max'], $label, $max);
                return false;
            }

            if (!$this->isNumericType($type) && strlen($value) > $max) {
                $this->errors[] = sprintf($this->errorMessages['max-string'], $label, $max);
                return false;
            }
        }
        return true;
    }

    private function isNumericType(string $type): bool
    {
        return array_key_exists($type, $this->numericTypes);
    }

    private function validateNumericType(string $type, mixed $value, string $label): bool
    {
        $typeFunction = $this->numericTypes[$type];

        if (!$typeFunction($value)) {
            $this->errors[] = sprintf($this->errorMessages[$type], $label);
            return false;
        }
        return true;
    }

    private function validateWithRegex(string $type, mixed $value, string $label): bool
    {
        if (!array_key_exists($type, $this->types)) {
            throw new \Exception("Type $type does not exists in Validator.");
        }

        $typeRegex = $this->types[$type];
        if (preg_match($typeRegex, $value) !== 1) {
            $this->errors[] = sprintf($this->errorMessages[$type], $label);
            return false;
        }

        return true;
    }

    public function hasErrors(): bool
    {
        if (empty($this->errors)) {
            return false;
        }
        return true;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

}
