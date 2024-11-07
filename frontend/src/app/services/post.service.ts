import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, map, catchError } from 'rxjs';
import { Post } from '../models/posts.model';

@Injectable({
  providedIn: 'root'
})
export class PostService {
  private apiUrl = 'http://localhost:8888/EduLabs/api/postlist/';
  private ApiCreatePost = 'http://localhost:8888/EduLabs/api/createpost/';

  constructor(private http: HttpClient) { }

  getPosts(): Observable<Post[]> {
    return this.http.get<any>(this.apiUrl).pipe(
      map(response => {
        console.log('Respuesta de la API:', response); // Para depuración
        
        // Si la respuesta es un objeto con una propiedad que contiene el array
        if (response && typeof response === 'object') {
          // Buscar una propiedad que contenga el array de posts
          const possibleArrayProps = Object.values(response);
          const postsArray = possibleArrayProps.find(prop => Array.isArray(prop));
          
          if (postsArray) {
            return postsArray as Post[];
          }
        }
        
        // Si la respuesta ya es un array
        if (Array.isArray(response)) {
          return response;
        }
        
        // Si no podemos encontrar un array, retornamos un array vacío
        console.error('No se pudo encontrar un array de posts en la respuesta:', response);
        return [];
      }),
      catchError(error => {
        console.error('Error en la petición:', error);
        throw error;
      })
    );
  }

  createPost(post: Post): Observable<Post> {
    return this.http.post<Post>(this.ApiCreatePost, post);
  }
}