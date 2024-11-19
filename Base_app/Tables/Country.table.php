<?php
class Country extends Table{
    public function __construct(){
        parent::__construct(2000001,'country');

        $this->field(1,'Code',FieldType::text(30));
        $this->field(2,'IsoCode',FieldType::text(10));
        $this->field(3,'Name',FieldType::text(50));

        $this->Keys('Code');
    }

    function onDelete()
    {
        $this->deleteCities();
    }

    function deleteCities()
    {
        $villes = new City();
        $villes->setRange('pays_code', $this->Code);
        if ($villes->FindSet()) {
            foreach ($villes->recordSet as $ville) {
                if (!$ville->Delete())
                    Error("Une erreur de suppression s'est produite pour la ville " . $ville->Code . ".");
            }
        }
    }
}
?>
