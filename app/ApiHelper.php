<?php
    namespace App;
    use Illuminate\Support\Facades\Http;

    class ApiHelper {
        public static function getLevels() {
            try {
                //code...
                $response = Http::get('http://localhost:1337/api/education-levels');
    
                if ($response->successful()) {
                    foreach ($response['data'] as $level) {
                        $level_id = $level['id'] ?? null;
                        $attributes = $level['attributes'] ?? null;
                        $level_name = $attributes['level_name'] ?? null;
    
                        if ($level_id !== null && $level_name !== null) {
                            $levels[$level_id] = $level_name;
                        }
                    }
                    // dd($levels);
                    return $levels;
                }
            } catch (\Throwable $th) {
                //throw $th;
                return view('errors.500');
            }

            return null;
        }

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
