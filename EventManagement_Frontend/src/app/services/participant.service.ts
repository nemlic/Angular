import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ParticipantService {
  private baseUrl = 'http://localhost:8000/api';

  constructor(private http: HttpClient) {}

  getEvents(): Observable<any> {
    return this.http.get(`${this.baseUrl}/events`);
  }

  registerForEvent(eventId: number): Observable<any> {
    return this.http.post(`${this.baseUrl}/events/${eventId}/register`, {});
  }
}
