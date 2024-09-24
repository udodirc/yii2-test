<?php

namespace app\modules\api\mappers;

use app\models\Patient;
use app\modules\api\dto\ServicePatientDto;

class ServicePatientMapper
{
    /**
     * @param Patient[] $patients
     * @return self[]
     */
    public static function mapAll(array $patients): array
    {
        return array_map([self::class, 'map'], $patients);
    }

    public static function map(Patient $patient): ServicePatientDto
    {
        $dto = new ServicePatientDto();

        $dto->id = $patient->id;
        $dto->name = $patient->name;
        $dto->birthday = $patient->birthday;
        $dto->phone = $patient->phone;
        $dto->address = $patient->address;
        $dto->polyclinic = $patient->polyclinic->name;
        $dto->status = $patient->status->name;
        $dto->treatment = $patient->treatment->name;
        $dto->form_disease = $patient->formDisease->name;
        $dto->updated_by = $patient->updatedBy->username . ' '.date("d.m.Y H:i:s", strtotime($patient->updated));
        $dto->recovery_date = $patient->recovery_date;

        return $dto;
    }
}