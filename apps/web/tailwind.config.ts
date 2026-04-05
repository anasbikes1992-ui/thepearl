import type { Config } from "tailwindcss";

const config: Config = {
  content: ["./src/**/*.{ts,tsx}"],
  theme: {
    extend: {
      colors: {
        pearl: {
          navy: "#0A2540",
          gold: "#D4AF77",
          cream: "#F8F1E3"
        }
      },
      fontFamily: {
        display: ["Cormorant Garamond", "serif"],
        body: ["Manrope", "sans-serif"]
      }
    }
  }
};

export default config;
