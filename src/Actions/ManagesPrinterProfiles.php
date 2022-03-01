<?php

namespace TechEnby\OctoPrint\Actions;

use TechEnby\OctoPrint\Resources\Profile;

trait ManagesPrinterProfiles
{
    public function profiles()
    {
        return $this->transformCollection(
            $this->get('printerprofiles')['profiles'], Profile::class
        );
    }

    public function profile($id)
    {
        return new Profile($this->get("printerprofiles/{$id}"));
    }

    public function createProfile($data, $basedOn = null)
    {
        if($basedOn) {
            return new Profile($this->post("printerprofiles", ['json' => ['profile' => $data, 'basedOn' => $basedOn]])['profile']);
        }

        return new Profile($this->post("printerprofiles", ['json' => ['profile' => $data]])['profile']);
    }

    public function updateProfile($id, $data)
    {
        return new Profile($this->post("printerprofiles/{$id}", ['json' => ['profile' => $data]])['profile']);
    }

    public function deleteProfile($id)
    {
        $this->delete("printerprofiles/{$id}");
    }
}
