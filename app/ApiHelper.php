<?php
    namespace App;
    use Illuminate\Support\Facades\Http;

    class ApiHelper {
        public static function getUnits() {
            $response = Http::get('http://localhost:1337/api/faculty-or-schools');

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        }

        public static function getProgrammes(){
            $response = Http::get('http://localhost:1337/api/programmes');
            if($response->successful()){
                return $response->json();
            }
        }

        public static function getYearOfStudy(){
            $response = Http::get('http://localhost:1337/api/year-of-studies');
            if($response->successful()){
                return $response->json();
            }
        }

        public static function getUsers() {
            $response = Http::get('http://localhost:1337/api/users');

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        }

    }
