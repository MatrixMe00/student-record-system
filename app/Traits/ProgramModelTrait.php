<?php

    namespace App\Traits;
    use App\Models\Program;

    trait ProgramModelTrait
    {
        protected function jhs3_object(){
            return Program::whereRaw("LOWER(name) = ?", ["jhs 3"])
                          ->orWhereRaw("LOWER(name) = ?", ["jhs3"]);
        }

        protected function jhs3_exists(){
            return $this->jhs3_object()->exists();
        }

        protected function jhs3(){
            return $this->jhs3_object()->first();
        }
    }
