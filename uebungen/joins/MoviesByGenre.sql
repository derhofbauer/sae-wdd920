SELECT movies.*, genres.name
    FROM movies
             JOIN genres_movies_mm
                  ON movies.id = genres_movies_mm.movie_id
             JOIN genres
                  ON genres.id = genres_movies_mm.genre_id
    WHERE genres.name = 'Action';
