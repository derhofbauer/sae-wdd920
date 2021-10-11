SELECT actors.*
    FROM actors
             JOIN actors_movies_mm
                  ON actors.id = actors_movies_mm.actor_id
             JOIN movies
                  ON movies.id = actors_movies_mm.movie_id
             JOIN genres_movies_mm
                  ON movies.id = genres_movies_mm.movie_id
             JOIN genres
                  ON genres.id = genres_movies_mm.genre_id
    WHERE genres.name = 'Action';
