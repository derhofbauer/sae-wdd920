<?php

namespace Models\Houses;

use Traits\OwnerTrait;

class House
{
    use OwnerTrait;

    private string $mortgageInfo = 'ölasdlhasldjhasd';

    public function getMortgageInfo () {
        return $this->mortgageInfo;
    }

    public function updateMortgageInfoFromDb () {
        // ...
        $updatedData = 'asdüdsyuöoasdf';

        $this->mortgageInfo = $updatedData;
    }
}
