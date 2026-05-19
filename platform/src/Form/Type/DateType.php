<?php

namespace Platform\Form\Type;

use Platform\Form\FormBuilder;

class DateType extends FieldsetType
{
    public function build(FormBuilder $builder): void
    {
        $builder
            ->add('date[day]', NumberType::class, [
                'label' => 'Day',
                'min' => 1,
                'max' => 31,
            ])
            ->add('date[month]', SelectType::class, [
                'label' => 'Month',
                'choices' => $this->getMonths(),
            ])
            ->add('date[year]', NumberType::class, [
                'label' => 'Year',
            ])
        ;
    }

    private function getMonths(): array
    {
        $months = [];
        for ($a = 1; $a <= 12; $a++) {
            $months[$a] = \DateTime::createFromFormat('!m', (string) $a)->format('F');
        }

        return $months;
    }
}
