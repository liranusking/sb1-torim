import React, { useState, useEffect } from 'react';
import axios from 'axios';

interface Service {
  id: number;
  name: string;
  description: string;
  duration: number;
  price: number;
}

const ServiceList: React.FC = () => {
  const [services, setServices] = useState<Service[]>([]);

  useEffect(() => {
    const fetchServices = async () => {
      try {
        const response = await axios.get('http://localhost:8000/api/services');
        setServices(response.data);
      } catch (error) {
        console.error('Error fetching services:', error);
      }
    };

    fetchServices();
  }, []);

  return (
    <div>
      <h2>Services</h2>
      <ul>
        {services.map((service) => (
          <li key={service.id}>
            {service.name} - {service.duration} minutes - ${service.price}
          </li>
        ))}
      </ul>
    </div>
  );
};

export default ServiceList;