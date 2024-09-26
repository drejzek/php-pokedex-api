<?php

class Pokémon
{

    public string $PokémonName;

    public bool $jsonOutput;

    public string $id;
    public string $name;
    public string $weight;
    public string $height;
    public string $types;
    public string $abilities;

    public function __construct($name, $jsonOutput = false)
    {
        $this->PokémonName = $name;
        $this->jsonOutput = $jsonOutput;
    }

    public function GetSingle()
    {
        $pid = $this->PokémonName;

        $getPokemonData = [];
        $getPokemonSpecies = [];
        $desiredProperties = [];

        if(isset($pid))
        {
            if($pid != "")
            {
                $style  = "block";
                $sstyle = "none";

                //General informations

                $headers = @get_headers('https://pokeapi.co/api/v2/pokemon/' . $pid);
                $status = explode(" ", $headers[0]);

                if ($headers)
                {
                    if($status[1] == 200)
                    {
                        $str = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $pid);
                        $pokemonData = json_decode($str, true);

                        // Získání požadovaných vlastností
                        $getPokemonData = [
                            "id" => $pokemonData["id"],
                            "name" => $pokemonData["name"],
                            "height" => $pokemonData["height"],
                            "weight" => $pokemonData["weight"],
                            "front_default" => $pokemonData["sprites"]["other"]["official-artwork"]["front_default"],
                            "front_shiny" => $pokemonData["sprites"]["other"]["official-artwork"]["front_shiny"]
                        ];

                        $types = [];
                        foreach ($pokemonData["types"] as $type) 
                        {
                            $types[] = $type["type"]["name"];
                        }
                        $desiredProperties["types"] = $types;

                        $abilities = [];
                        foreach ($pokemonData["abilities"] as $ability) 
                        {
                            $abilities[] = $ability["ability"]["name"];
                        }
                        $desiredProperties["abilities"] = $abilities;
                    }
                    else if($status[1] == 404)
                    {
                        trigger_error("Pokémon or Pokémon ID $pid was not found; $headers[0]", E_USER_ERROR);
                    }
                } 
                else 
                {
                    trigger_error("Can't get status code", E_USER_ERROR);
                }

                //Pokémon species

                $headers = @get_headers('https://pokeapi.co/api/v2/pokemon-species/' . $pid);
                $status = explode(" ", $headers[0]);

                if ($headers)
                {
                    if($status[1] == 200)
                    {
                        $str = file_get_contents('https://pokeapi.co/api/v2/pokemon-species/' . $pid);
                        $pokemonSpecies = json_decode($str, true);

                        // Získání požadovaných vlastností
                        $getPokemonSpecies = [
                            "base_happiness" => $pokemonSpecies["base_happiness"],
                            "capture_rate" => $pokemonSpecies["capture_rate"],
                            "color" => $pokemonSpecies["color"],
                            "egg_groups" => $pokemonSpecies["egg_groups"],
                            "evolution_chain" => $pokemonSpecies["evolution_chain"],
                            "evolves_from_species" => $pokemonSpecies["evolves_from_species"],
                            "forms_switchable" => $pokemonSpecies["forms_switchable"],
                            "gender_rate" => $pokemonSpecies["gender_rate"],
                            "generation" => $pokemonSpecies["generation"],
                            "growth_rate" => $pokemonSpecies["growth_rate"],
                            "habitat" => $pokemonSpecies["habitat"],
                            "has_gender_differences" => $pokemonSpecies["has_gender_differences"],
                            "hatch_counter" => $pokemonSpecies["hatch_counter"],
                            "id" => $pokemonSpecies["id"],
                            "is_baby" => $pokemonSpecies["is_baby"],
                            "is_legendary" => $pokemonSpecies["is_legendary"],
                            "is_mythical" => $pokemonSpecies["is_mythical"],
                            "name" => $pokemonSpecies["name"],
                            "order" => $pokemonSpecies["order"],
                            "pal_park_encounters" => $pokemonSpecies["pal_park_encounters"],
                            "pokedex_numbers" => $pokemonSpecies["pokedex_numbers"],
                            "shape" => $pokemonSpecies["shape"],
                            "varieties" => $pokemonSpecies["varieties"]
                        ];
                        

                        $types = [];
                        foreach ($pokemonData["types"] as $type) 
                        {
                            $types[] = $type["type"]["name"];
                        }
                        $desiredProperties["types"] = $types;

                        $abilities = [];
                        foreach ($pokemonData["abilities"] as $ability) 
                        {
                            $abilities[] = $ability["ability"]["name"];
                        }
                        $desiredProperties["abilities"] = $abilities;
                    }
                    else if($status[1] == 404)
                    {
                        trigger_error("Pokémon or Pokémon ID $pid was not found; $headers[0]", E_USER_ERROR);
                    }
                } 
                else 
                {
                    trigger_error("Can't get status code", E_USER_ERROR);
                }
            }
            else
            {
                trigger_error("Argument id is non-empty!", E_USER_ERROR);
            }
        }
        else
        {
            trigger_error("Argument id is required!", E_USER_ERROR);
        }

        $desiredProperties = array_merge($getPokemonData, $getPokemonSpecies);

        if($this->jsonOutput)
            return json_encode($desiredProperties, true);
        else
            return $desiredProperties;

    }

    public function getTypeColor($type = '0')
    {
        $typecolors = [
            'bug' => '#729F3F',
            'dragon' => '#F16E57',
            'fairy' => '#FDB9E9',
            'fire' => '#FD7D24',
            'ghost' => '#7B62A3',
            'ground' => '#8F4521',
            'normal' => '#A4ACAF',
            'psychic' => '#F366B9',
            'steel' => '#9EB7B8',
            'dark' => '#707070',
            'electric' => '#EED535',
            'fighting' => '#D56723',
            'flying' => '#729FB8',
            'grass' => '#9BCC50',
            'ice' => '#51C4E7',
            'poison' => '#B97FC9',
            'rock' => '#A38C21',
            'water' => '#4592C4'
        ];
        return isset($typecolors[$type]) ? $typecolors[$type] : 'undefined';
    }

    public function getGender()
    {
        $pid = $this->PokémonName;

        if(isset($pid))
        {
            if($pid != "")
            {
                $style  = "block";
                $sstyle = "none";
                $headers = @get_headers('https://pokeapi.co/api/v2/gender/' . $pid);
                $status = explode(" ", $headers[0]);

                if ($headers)
                {
                    if($status[1] == 200)
                    {
                        $str = file_get_contents('https://pokeapi.co/api/v2/gender/' . $pid);
                        // $str = file_get_contents('bulbasaur-evch.json');
                        
                        $g = json_decode($str, true);

                        $gender = $g['name'];
                    
                        return $gender;
                    }
                    else if($status[1] == 404)
                    {
                        trigger_error("Pokémon or Pokémon ID $pid was not found; $headers[0]", E_USER_ERROR);
                    }
                } 
                else 
                {
                    trigger_error("Can't get status code", E_USER_ERROR);
                }
            }
            else
            {
                trigger_error("Argument id is non-empty!", E_USER_ERROR);
            }
        }
        else
        {
            trigger_error("Argument id is required!", E_USER_ERROR);
        }
    }

    public function getEvolutionChain($type)
    {
        $pid = $this->PokémonName;

        if(isset($pid))
        {
            if($pid != "")
            {
                switch($type)
                {
                    case "chain":
                        $style  = "block";
                        $sstyle = "none";
                        $headers = @get_headers('https://pokeapi.co/api/v2/pokemon-species/' . $pid);
                        $status = explode(" ", $headers[0]);

                        if ($headers)
                        {
                            if($status[1] == 200)
                            {
                                $str = file_get_contents('https://pokeapi.co/api/v2/pokemon-species/' . $pid);
                                // $str = file_get_contents('bulbasaur-evch.json');
                                
                                $ec_url = json_decode($str, true);

                                $evid = $ec_url['evolution_chain']['url'];

                                $ec_json = file_get_contents($evid);
                                // $str = file_get_contents('bulbasaur-evch.json');
                                
                                $pokemonEvolChain = json_decode($ec_json, true);

                                $baby = [
                                    "name" => null
                                ];
                                $first_gen = [
                                    "name" => null
                                ];
                                $second_gen = [
                                    "name" => null
                                ];
                                $third_gen = [
                                    "name" => null
                                ];
                                
                                if(isset($pokemonEvolChain['chain']['species']))
                                {
                                    $baby = $pokemonEvolChain['chain']['species'];
                                }
                                if(isset($pokemonEvolChain['chain']['evolves_to'][0]['species']))
                                {
                                    $first_gen = $pokemonEvolChain['chain']['evolves_to'][0]['species'];
                                }
                                if(isset($pokemonEvolChain['chain']['evolves_to'][0]['evolves_to'][0]['species']))
                                {
                                    $second_gen = $pokemonEvolChain['chain']['evolves_to'][0]['evolves_to'][0]['species'];
                                }
                                if(isset($pokemonEvolChain['chain']['evolves_to'][0]['evolves_to'][0]['evolves_to'][0]['species']))
                                {
                                    $third_gen =  $pokemonEvolChain['chain']['evolves_to'][0]['evolves_to'][0]['evolves_to'][0]['species'];
                                }

                                $evolutionChain = [
                                    "baby" => $baby['name'],
                                    "first" => $first_gen['name'],
                                    "second" => $second_gen['name'],
                                    "third" => $third_gen['name']
                                ];
                            
                                if($this->jsonOutput)
                                    return json_encode($evolutionChain, true);
                                else
                                    return $evolutionChain;
                            }
                            else if($status[1] == 404)
                            {
                                trigger_error("Pokémon or Pokémon ID $pid was not found; $headers[0]", E_USER_ERROR);
                            }
                        } 
                        else 
                        {
                            trigger_error("Can't get status code", E_USER_ERROR);
                        }
                    break;
                    case "id":
                        $headers = @get_headers('https://pokeapi.co/api/v2/pokemon-species/' . $pid);
                        $status = explode(" ", $headers[0]);

                        if ($headers)
                        {
                            if($status[1] == 200)
                            {
                                $str = file_get_contents('https://pokeapi.co/api/v2/pokemon-species/' . $pid);
                                // $str = file_get_contents('bulbasaur-evch.json');
                                
                                $ec_url = json_decode($str, true);

                                $url_full = $ec_url['evolution_chain']['url'];

                                $url = explode('//', $url_full);
                                $url2 = explode('/', $url['1']);

                                return $url2['4'];
                            }
                        }
                    break;
                }
            }
            else
            {
                trigger_error("Argument id is non-empty!", E_USER_ERROR);
            }
        }
        else
        {
            trigger_error("Argument id is required!", E_USER_ERROR);
        }
    }

    public function getSet($limit)
    {
        $style  = "block";
        $sstyle = "none";
        $headers = @get_headers('https://pokeapi.co/api/v2/pokemon/?limit=' . $limit);
        $status = explode(" ", $headers[0]);

        if ($headers)
        {
            if($status[1] == 200)
            {
                $str = file_get_contents('https://pokeapi.co/api/v2/pokemon/?limit=' . $limit);
                $pokemonData = json_decode($str, true);

                if($this->jsonOutput)
                    return json_encode($$pokemonData['results'], true);
                else
                    return $$pokemonData['results'];

            }
            else if($status[1] == 500)
            {
                trigger_error("Something wet wrong; $headers[0]", E_USER_ERROR);
            }
        } 
        else 
        {
            trigger_error("Can't get status code", E_USER_ERROR);
        }
    }
}