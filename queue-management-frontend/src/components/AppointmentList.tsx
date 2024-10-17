import React, { useState, useEffect } from 'react';
import axios from 'axios';

interface Appointment {
  id: number;
  start_time: string;
  end_time: string;
  status: string;
  service: {
    name: string;
  };
}

const AppointmentList: React.FC = () => {
  const [appointments, setAppointments] = useState<Appointment[]>([]);

  useEffect(() => {
    const fetchAppointments = async () => {
      try {
        const response = await axios.get('http://localhost:8000/api/appointments');
        setAppointments(response.data);
      } catch (error) {
        console.error('Error fetching appointments:', error);
      }
    };

    fetchAppointments();
  }, []);

  return (
    <div>
      <h2>Appointments</h2>
      <ul>
        {appointments.map((appointment) => (
          <li key={appointment.id}>
            {appointment.service.name} - {new Date(appointment.start_time).toLocaleString()} - {appointment.status}
          </li>
        ))}
      </ul>
    </div>
  );
};

export default AppointmentList;