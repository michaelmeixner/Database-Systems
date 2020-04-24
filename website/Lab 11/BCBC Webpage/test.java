import java.util.*;
public class test {
    public static void main(String[] args) {
        String test = "20,Michael M,ESPN;149,Math M,CSCI";
        StringTokenizer st = new StringTokenizer(test, ";,");
        System.out.println(st);
		ArrayList<String> strings = new ArrayList<String>();
		while(st.hasMoreElements()) {
			strings.add(st.nextToken());
		}
		for(int i = 0; i < strings.size(); i++) {
			System.out.println(strings.get(i));
		}
    }
}