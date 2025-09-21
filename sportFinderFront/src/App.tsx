import { useState, useEffect } from "react";
import axios from "axios";

// Interface para os dados da API
interface User {
  id: number;
  nome: string;
  email: string;
  created_at: string;
  updated_at: string;
}

export default function App() {
  const [data, setData] = useState<User | null>(null); // tipagem correta

  const [loading, setLoading] = useState(true);
  const API_URL = import.meta.env.VITE_API_URL; // pega da .env

  useEffect(() => {
  async function fetchData() {
    try {
      const response = await axios.get<User>(`${API_URL}/usuarios/1`);
      setData(response.data);
    } catch (error) {
      console.error("Erro ao buscar dados:", error);
    } finally {
      setLoading(false);
    }
  }

  fetchData();
}, [API_URL]);

if (loading) return <p>Carregando...</p>;

return (
  <div>
    <h1>Dados do Usuário</h1>
    <pre>{JSON.stringify(data, null, 2)}</pre>
    <p>Nome: {data?.nome}</p>
    <p>Email: {data?.email}</p>
  </div>
);
}
