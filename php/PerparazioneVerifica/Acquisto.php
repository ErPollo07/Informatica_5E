<?php

class Acquisto
{
    private int $id;
    private int $personaId;
    private string $dataInizio;
    private string $dataFine;
    private int $quantitaTeli;
    private int $prezzo;
    private array $lettini;
    private array $ombrelloni;

    public function __construct(int $id, int $personaId, string $dataInizio, string $dataFine, int $quantitaTeli, int $prezzo, array $lettini, array $ombrelloni)
    {
        $this->id = $id;
        $this->personaId = $personaId;
        $this->dataInizio = $dataInizio;
        $this->dataFine = $dataFine;
        $this->quantitaTeli = $quantitaTeli;
        $this->prezzo = $prezzo;
        $this->lettini = $lettini;
        $this->ombrelloni = $ombrelloni;
        echo "id: " . $this->id . ", personaId: " . $this->personaId . ", dataInizio: " . $this->dataInizio . ", dataFine: " . $this->dataFine . ", quantitaTeli: " . $this->quantitaTeli . ", prezzo: " . $this->prezzo . "<br>";
    }

    public function setLettini(array $lettini): void
    {
        $this->lettini = $lettini;
    }

    public function setOmbrelloni(array $ombrelloni): void
    {
        $this->ombrelloni = $ombrelloni;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPersonaId(): int
    {
        return $this->personaId;
    }

    public function getDataInizio(): string
    {
        return $this->dataInizio;
    }

    public function getDataFine(): string
    {
        return $this->dataFine;
    }

    public function getQuantitaTeli(): int
    {
        return $this->quantitaTeli;
    }

    public function getPrezzo(): int
    {
        return $this->prezzo;
    }

    public function getLettini(): array
    {
        return $this->lettini;
    }

    public function getOmbrelloni(): array
    {
        return $this->ombrelloni;
    }


}