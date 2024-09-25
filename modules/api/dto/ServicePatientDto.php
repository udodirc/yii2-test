<?php

namespace app\modules\api\dto;

class ServicePatientDto
{
    public int $id;
    public ?string $name;
    public ?string $birthday;
    public ?string $phone;
    public ?string $address;
    public ?string $polyclinic;
    public ?string $status;
    public ?string $treatment;
    public ?string $form_disease;
    public ?string $updated_by;
    public ?string $recovery_date;
}