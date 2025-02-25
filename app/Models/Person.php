<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Relationship;

class Person extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'people';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'birth_name',
        'middle_names',
        'date_of_birth',
        'created_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the user who created this person.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all children of this person.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Relationship::class, 'parent_id');
    }

    /**
     * Get all parents of this person.
     */
    public function parents(): HasMany
    {
        return $this->hasMany(Relationship::class, 'child_id');
    }

    public function getDegreeWith($targetId, $maxDegree = 25)
    {
        // Si c'est la même personne, le degré est 0
        if ($this->id == $targetId) {
            return 0;
        }
        
        $target = Person::find($targetId);
        
        // Vérifier si la personne cible existe
        if (!$target) {
            return false;
        }
        
        $queue = [[$this->id, 0]];
        
        $visited = [$this->id => true];
        
        $maxDegree = 25;
        
        while (!empty($queue)) {
            [$currentId, $degree] = array_shift($queue);
            
            // Si on a dépassé la limite, on arrête
            if ($degree > $maxDegree) {
                return false;
            }
            
            $current = Person::find($currentId);
            
            // Récupérer tous les parents
            $parents = $current->parents()->with('parent')->get();
            foreach ($parents as $relationship) {
                $parentId = $relationship->parent_id;
                
                // Si on a trouvé la cible
                if ($parentId == $targetId) {
                    return $degree + 1;
                }
                
                // Si on n'a pas encore visité cette personne
                if (!isset($visited[$parentId])) {
                    $visited[$parentId] = true;
                    $queue[] = [$parentId, $degree + 1];
                }
            }
            
            // Récupérer tous les enfants
            $children = $current->children()->with('child')->get();
            foreach ($children as $relationship) {
                $childId = $relationship->child_id;
                
                // Si on a trouvé la cible
                if ($childId == $targetId) {
                    return $degree + 1;
                }
                
                // Si on n'a pas encore visité cette personne
                if (!isset($visited[$childId])) {
                    $visited[$childId] = true;
                    $queue[] = [$childId, $degree + 1];
                }
            }
        }
        
        // Si on a exploré tout le graphe sans trouver la cible
        return false;
    }
}