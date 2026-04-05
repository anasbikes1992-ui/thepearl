export const messages = {
  en: {
    heading: "Discover Trusted Luxury Services",
    cta: "Start booking"
  },
  si: {
    heading: "විශ්වාසනීය ලක්සරි සේවා සොයාගන්න",
    cta: "දැන් වෙන් කරන්න"
  },
  ta: {
    heading: "நம்பகமான லக்ஷுரி சேவைகளை கண்டறியுங்கள்",
    cta: "இப்போது பதிவு செய்யவும்"
  }
} as const;

export type Locale = keyof typeof messages;
