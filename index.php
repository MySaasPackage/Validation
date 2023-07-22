<?php

declare(strict_types=1);

class FieldViolation implements Violation
{
    protected Violation|null $sibling = null;

    public function __construct(
        public readonly string $field,
        public readonly Violation $violation
    ) {
    }

    public function hasSibling(): bool
    {
        return null !== $this->sibling;
    }

    public function addSibling(Violation $sibling): Violation
    {
        if ($this->hasSibling()) {
            $this->sibling->addSibling($sibling);
        } else {
            $this->sibling = $sibling;
        }

        return $this;
    }

    public function __toArray(): array
    {
        return [$this->field => $this->violation->__toArrayWithSiblings()];
    }

    public function __toArrayWithSiblings(): array
    {
        $output = $this->__toArray();

        if ($this->hasSibling()) {
            return array_merge($output, $this->sibling->__toArrayWithSiblings());
        }

        return $output;
    }
}

$emailViolation = (new SimpleViolation(keyword: 'required'))->addSibling((new SimpleViolation(keyword: 'string'))->addSibling(new SimpleViolation(keyword: 'email')));
$phoneViolation = (new SimpleViolation(keyword: 'required'))->addSibling((new SimpleViolation(keyword: 'string'))->addSibling(new SimpleViolation(keyword: 'phone')));

$emailFieldViolation = new FieldViolation(field: 'email', violation: $emailViolation);
$email2FieldViolation = new FieldViolation(field: 'email', violation: $emailViolation);
$phoneFieldViolation = new FieldViolation(field: 'phone', violation: $phoneViolation);
$phone2FieldViolation = new FieldViolation(field: 'phone', violation: $phoneViolation);

$emailFieldViolation->addSibling($phoneFieldViolation);
$email2FieldViolation->addSibling($phone2FieldViolation);

$collectionViolation = (new SimpleViolation(keyword: 'required'))
    ->addSibling((new CollectionViolation($emailViolation))
        ->addSibling(new CollectionViolation($emailViolation)));

$collectionFieldViolation = new FieldViolation(field: 'list', violation: $collectionViolation);

$nestedFieldViolation = new FieldViolation(field: 'nested', violation: $emailFieldViolation);
echo json_encode($collectionViolation->__toArrayWithSiblings(), JSON_PRETTY_PRINT);
